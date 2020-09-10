echo "Starting Auto Deploy Script for GoComet"
echo "***************************************"
cd gocomet-assignment
echo "directory changed to gocomet-assignment"
git reset --hard
echo "hard reset the repo"
git pull origin master
echo "pulled from origin master"
cd ..
echo "changed directory to 1 level back"
rm -R ../../public_html/medium-crawler/*
echo "deleted already deployed code"
mkdir ../../public_html/medium-crawler/develop
echo "created develop folder inside deploy folder"
mv -v ./gocomet-assignment/public/* ../../public_html/medium-crawler/
echo "moved all files and folder inside public folder to root of deploy folder"
rm ../../public_html/medium-crawler/index.php
echo "deleted index.php from root of deploy folder"
cp  -v ./index.php ../../public_html/medium-crawler/
echo "moved actual index.php to deploy folder"
rm -R ./gocomet-assignment/public
echo "deleted public folder from gocomet-repo folder"
mv -v ./gocomet-assignment/* ../../public_html/medium-crawler/develop
echo "moved all the root level files/folders to develop folder of deploy folder"
rm ../../public_html/medium-crawler/develop/.env
echo "deleted old .env file"
cp  -v ./.env ../../public_html/medium-crawler/develop
echo "moved .env file to develop folder of deploy folder"
cd ../../public_html/medium-crawler/develop
echo "changing directory to develop of deploy folder"
composer install
echo "composer install done"
php artisan migrate
echo "Database Migration done"
echo "Auto Deploy Completed"
echo "*********************"

