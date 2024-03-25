import cv2
from deepface import DeepFace
import os
from config import create_conn
import shutil
from PIL import Image
import time

# Variables
parent_dir = os.path.abspath(os.path.join(os.path.abspath(os.path.dirname(__file__)), os.pardir))

def save_image_to_database(source_file_path, filename):
    ''' Save image details to database
    
    Moves the inbound image to a new directory, then saves the image details
    to the database. Returns the new image file path
    '''
    # Set destination image directory
    destination_dir = os.path.join(parent_dir, 'images')

    # move inbound image to destination directory
    print(f"Moving {filename} to {destination_dir}")
    shutil.move(source_file_path, destination_dir)

    # create a thumbnail for the image
    thumb_path = create_thumbnail(destination_dir, filename)
    # save image details to database
    conn = create_conn()
    if conn is not None:
        cursor = conn.cursor()
        query = "INSERT INTO image (filename, file_path, thumbnail_path) VALUES (%s, %s, %s)"
        values = (filename, os.path.join('images', filename), thumb_path)
        cursor.execute(query, values)
        conn.commit()
        print(f"Image {filename} added successfully")
        cursor.close()
        conn.close()
    return os.path.join('images', filename)

def save_face_region(x, y, w, h, face_filename, original_image_path, confidence, is_face):
    """ Save face region to file
    
    Locates the given face region in the original image and saves image
    to a directory, then saves image details to database.
    """
    # Set face region save directory
    directory = os.path.join('images', 'faces')

    # save face region to a file
    img = cv2.imread(original_image_path)
    face_region = img[y:y+h, x:x+w]
    face_region_path = os.path.join(directory, face_filename)
    cv2.imwrite(os.path.join(parent_dir, face_region_path), face_region)
    
    # save face details to database
    conn = create_conn()
    if conn is not None:
        cursor = conn.cursor()
        query_select = "SELECT image_id FROM image WHERE file_path = %s"
        cursor.execute(query_select, (original_image_path.split(f"{parent_dir}\\")[1],))
        image_id = cursor.fetchone()
        query_insert = "INSERT INTO face (image_id, filename, file_path, x_axis, y_axis, width, height, confidence, is_face) " \
                        "VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
        values = (image_id[0], face_filename, face_region_path, x, y, w, h, confidence, is_face)
        cursor.execute(query_insert, values)
        conn.commit()
        print(f"Image {face_filename} added successfully")
        cursor.close()
        conn.close()

def create_thumbnail(image_path, filename):
    """ Create thumbnail for image

    Create a thumbnail for the given image, saves to a 
    new directory
    """
    # set max size of thumbnail
    MAX_SIZE = (200, 200)
    # set thumbnail save directory
    thumb_dir = os.path.join(image_path, "thumbnails")

    image = Image.open(rf"{os.path.join(image_path, filename)}")
    image.thumbnail(MAX_SIZE)
    directory = os.path.join(thumb_dir, filename)
    image.save(rf"{directory}")
    return os.path.join('images', 'thumbnails', filename)

def face_confidence(confidence):
    """ Determine a pass/fail for confidence
    
    Compares the confidence parameter with the specified minimum confidence
    level. Returns boolean True/False
    """
    # set confidence level
    minimum_confidence = 0.95
    result = True if confidence > minimum_confidence else False
    return result

def face_detection(original_image_path, filename_with_ext):
    """ Detect faces in image with configured detection backend
    
    Detects faces in the given image then saves face details to database
    """
    filename_no_ext = os.path.splitext(filename_with_ext)[0]

    # Face Detection Backend Options {Options: 'opencv', 'retinaface', 'mtcnn', 'ssd', 'dlib', 'mediapipe', 'yolov8' (default is opencv).}
    backend = 'retinaface'
    results = DeepFace.extract_faces(img_path = original_image_path,
                                     target_size = (224, 224),
                                     detector_backend = backend,
                                     align=True)
    count = 0

    for result in results:
        x, y, w, h = result['facial_area']['x'], result['facial_area']['y'], result['facial_area']['w'], result['facial_area']['h']
        confidence = result['confidence']
        face_filename = f"{filename_no_ext}-fr{count}.jpg"
        is_face = face_confidence(confidence)
        save_face_region(x, y, w, h, face_filename, original_image_path, confidence, is_face)
        count += 1

def main():
    """ Execute the face detection application
    
    Locates images in specified inbound directory, moves them to 'images' directory
    then runs the face detection alogorithm for each image.
    """
    # Set inbound image directory
    directory = os.path.join(parent_dir, 'photos')

    if not os.path.isdir(directory):
        print(f"The directory named {directory} does not exist.")
        return
    
    files = os.listdir(directory)

    if not files:
        print(f"No files found in the {directory} directory.")
        return
    
    for image in files:
        file_path = os.path.join(directory, image)
        if os.path.isfile(file_path):
            filename_with_ext = file_path.split(f"{directory}\\")[1]
            new_file_path = save_image_to_database(file_path, filename_with_ext)
            face_detection(os.path.join(parent_dir, new_file_path), filename_with_ext)
        else:
            print(f"'{image}' is not a file.")


if __name__ == "__main__":
   start_time = time.time()
   main()
   print("--- %s senconds ---" % (time.time() - start_time))