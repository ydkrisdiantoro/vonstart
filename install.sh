#!/bin/bash

# Cek apakah argumen folder tujuan telah diberikan
if [ "$#" -eq 0 ]; then
    echo "Usage: $0 <tujuan>"
    exit 1
fi

# Cara menjalankan: ./install.sh nama-repo
# Nama Repo tujuan
subfolder="$1"

cp "app/Http/Middleware/VcontrolMiddleware.php" "../$subfolder/app/Http/Middleware/VcontrolMiddleware.php"
cp -r "app/Http/Controllers/" "../$subfolder/app/Http/Controllers"
cp -r "app/Models/" "../$subfolder/app/Models"
cp -r "database/migrations/" "../$subfolder/database/migrations"
cp -r "database/seeders/VcontrolSeeder.php" "../$subfolder/database/seeders/VcontrolSeeder.php"
cp "routes/web.php" "../$subfolder/routes/web.php"
cp -r "app/Services/" "../$subfolder/app/Services"
cp -r "resources/views/" "../$subfolder/resources/views"
cp "config/vcontrol.php" "../$subfolder/config/vcontrol.php"
cp -r "app/Helpers/" "../$subfolder/app/Helpers"
cp -r "public/assets/" "../$subfolder/public/assets"

echo "Vonstart added succesfully!"