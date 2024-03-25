# From the Archives

### Initial Setup procedure

1. You will need XAMPP up and running
2. Clone this repository into your htdocs folder
3. Create a database called "photos_db"
4. Run the 'photos_db.sql' SQL script to create the necessary tables
5. Make sure MySQL and Apache are running in XAMPP

### Face Detection

1. Add new photos into the /photos folder
2. From the terminal run detection-app/face-detection.py
3. The script will process the new photos and save data to the DB

### Opening the webpage, viewing the results

1. In a browser, open localhost/web-app/app.ctrl.php
2. You should see the gallery of processed images
3. Click on each image to see the bounding boxes found around detected faces
