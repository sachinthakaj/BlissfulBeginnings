<?php

class m0012_SampleData {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = 'INSERT INTO `vendors` (`vendorID`, `email`, `password`, `businessName`, `typeID`, `contact`, `address`,  `description`, `rating`, `imgSrc`, `websiteLink`, `vendorstate`) VALUES
(0x1415e1b4a8b211efac950a0027000004, \'kamalflora@gmail.com\', \'$2y$10$cOTf5/ccPqIFGCAWKMZ.zui/6gqYcKj.HRSUuOn/J8r8qh9tpXoB6\', \'Kamal Flora\', \'Florist\', \'0711234566\', \'127,main street,colombo\',  \'flora\',0, NULL, \'navodtailors.lk\', \'new\'),
(0x3f9891a9a8b211efac950a0027000004, \'hasinifashion@gmail.com\', \'$2y$10$lrC1m.snOE.8neexlOMj9utWdoGlXhhZaxYJr.7VurFzG8uEep6Fm\', \'Hasini Fashion\', \'Dress Designer\', \'0711234596\', \'130,main street,colombo\', \'Hasini jkkl\', 0, NULL, \'navodtailors.lk\',\'new\'),
(0xac902193a8b111efac950a0027000004, \'sandalisalon@gmail.com\', \'$2y$10$tTpibYjUrCN.cV5/xVFPeeIKZ49uYadwCVgh2kOU/sueuniHdtSJq\', \'Sandali  Salon\', \'Salon\', \'0711234567\', \'123,main street,colombo\',  \'sandali\',0, NULL, \'navodtailors.lk\', \'new\'),
(0x77c10035acd411ef8612cc153136262a, \'navodtailors@gmail.com\', \'$2y$10$3e5xd8gxxemSlbXqllWLkOPyyT/gp9itN5LAGNbQND0V6UX2ziyxW\', \'Navod Tailors\', \'Dress Designer\', \'0714021757\', \'No.95/B, Kandy Road, Dalugama, Kelaniya\', \'Celebrate your love story with a bespoke bridal design from Navod Tailors. Our passion lies in creating one-of-a-kind wedding dresses that embody grace, sophistication, and individuality. From intricate lace details to flowing satin skirts, we use the finest materials to craft gowns that perfectly fit your vision. At Navod Tailors, we ensure your dress is as unforgettable as the day itself, making you feel radiant and confident every step of the way.\', 0, NULL, \'navodtailors.lk\', \'new\'),
(0xe00e1dc1a8b111efac950a0027000004, \'sakyastudio@gmail.com\', \'$2y$10$q0YLSwPvI3C8NP.zNe9wWeUEkwoVFbz3w0A5.qwAz1S3u7./HSLWq\', \'Sakya Studio\', \'Photographer\', \'0711234567\', \'124,main street,colombo\', \'sakya studi\',0, NULL, \'navodtailors.lk\', \'new\');

INSERT INTO `users` (`userID`, `email`, `password`) VALUES
(0x406b854ba8a511ef8612cc153136262a, \'navod@gmail.com\', \'$2y$10$XER0sKO32loJ8xrypU72wedHQ79dZAVlsmns2J8fuO0aQtux2Vqei\'),
(0x6dfc6fe5a8a611ef8612cc153136262a, \'umb@yahoo.com\', \'$2y$10$.bJn9UIbtl.Dj/cXq3BtVeKf3Op7ri/3R9E9N1dgkoCv6pqQVjKDq\'),
(0x6f1c12aea8a711ef8612cc153136262a, \'ph@fast.lk\', \'$2y$10$EtUdUurlBK3AWZ7REpv7cucACeOj37OdtYu1UhvMWUyALXvUXUzue\'),
(0xf19616d5a8a211ef8612cc153136262a, \'emil.navod@gmail.com\', \'$2y$10$/8MkhM/Eyr1qvEl5JSuhA.TMX9lJa37rE/Ppy91yALo5rXgEaWGty\');

INSERT INTO `wedding` (`weddingID`, `userID`, `date`, `dayNight`, `location`, `theme`, `budget`, `currentPaid`, `numTasks`, `currentCompleted`, `sepSalons`, `sepDressDesigners`, `weddingState`) VALUES
(0x2ecb172ea8a311ef8612cc153136262a, 0x406b854ba8a511ef8612cc153136262a, \'2024-11-23\', \'Day\', \'Colombo\', \'Kandyan\', 10000000, NULL, NULL, NULL, 1, 0, \'new\'),
(0x422d8239a8a611ef8612cc153136262a, 0x6dfc6fe5a8a611ef8612cc153136262a, \'2024-12-06\', \'Night\', \'Kandy\', \'Western\', 190000, NULL, NULL, NULL, 0, 1, \'new\'),
(0xa9129b1ba8a611ef8612cc153136262a, 0x6f1c12aea8a711ef8612cc153136262a, \'2024-12-20\', \'Day\', \'Colombo\', \'Blue\', 150000, NULL, NULL, NULL, 1, 1, \'new\'),
(0xaec44e7ba8a711ef8612cc153136262a, 0xf19616d5a8a211ef8612cc153136262a, \'2024-12-27\', \'Night\', \'Kandy\', \'Western\', 1900000, NULL, NULL, NULL, 0, 1, \'new\');


INSERT INTO `bridegrooms` (`brideGroomsID`, `name`, `email`, `contact`, `address`, `gender`, `age`) VALUES
(0x2ecb478da8a311ef8612cc153136262a, \'Samanmali\', \'Samanmali@gmail.com\', \'0714022345\', \'No. 08 Kotte Road, Kotte\', \'Female\', 24),
(0x2ecb570aa8a311ef8612cc153136262a, \'Saman\', \'Saman@gmail.com\', \'0774455889\', \'No. 45 Temple Road, Kandy\', \'Male\', 23),
(0x422da7bea8a611ef8612cc153136262a, \'Udari\', \'Udari@gmail.com\', \'0775559999\', \'No.24 Church Road\', \'Female\', 35),
(0x422e0157a8a611ef8612cc153136262a, \'Udara\', \'Udara@gmail.com\', \'0719007005\', \'No. 67 School Rd, Kadawatha\', \'Male\', 35),
(0xa912cdb8a8a611ef8612cc153136262a, \'Rose\', \'Rose@gmail.com\', \'0112908999\', \'No. 67 Hospita Road, Negombo\', \'Female\', 45),
(0xa912d6cca8a611ef8612cc153136262a, \'Jack\', \'Jack@gmail.com\', \'0715882670\', \'45, 1st Cross Street, Pettah\', \'Male\', 55),
(0xaec48bd1a8a711ef8612cc153136262a, \'Himanshi\', \'Himanshi@gmail.com\', \'0714455678\', \'87/8 Hill road, Colombo 15\', \'Female\', 22),
(0xaec4e6d7a8a711ef8612cc153136262a, \'Neluka\', \'Arunalu@trace.lk\', \'0775558892\', \'No, 34 Matara Road, Ragama\', \'Male\', 22);

INSERT INTO `weddingbridegrooms` (`weddingID`, `brideID`, `groomID`) VALUES
(0x2ecb172ea8a311ef8612cc153136262a, 0x2ecb478da8a311ef8612cc153136262a, 0x2ecb570aa8a311ef8612cc153136262a),
(0x422d8239a8a611ef8612cc153136262a, 0x422da7bea8a611ef8612cc153136262a, 0x422e0157a8a611ef8612cc153136262a),
(0xa9129b1ba8a611ef8612cc153136262a, 0xa912cdb8a8a611ef8612cc153136262a, 0xa912d6cca8a611ef8612cc153136262a),
(0xaec44e7ba8a711ef8612cc153136262a, 0xaec48bd1a8a711ef8612cc153136262a, 0xaec4e6d7a8a711ef8612cc153136262a);


INSERT INTO `packages` (`packageID`, `vendorID`, `packageName`, `feature1`, `feature2`, `feature3`, `fixedCost`) VALUES
(0x189eec2faa3f11ef8612cc153136262a, 0x1415e1b4a8b211efac950a0027000004, \'Gold\', \'Flower Bouqet\', \'Sette Back\', \'Table Decoration\', 20000),
(0x2a309042a98d11ef8612cc153136262a, 0xac902193a8b111efac950a0027000004, \'Elite Wedding\', \'Facial Treatments\', \'Manicures\', \'Pedicures\', 180000),
(0x4fa7d5d6aa3f11ef8612cc153136262a, 0x3f9891a9a8b211efac950a0027000004, \'Bronze\', \'Saree\', \'\', \'\', 50000),
(0x6574a1d6aa3d11ef8612cc153136262a, 0xac902193a8b111efac950a0027000004, \'Platinum\', \'Facial\', \'Beauty treatments\', \'\', 1400),
(0x7da01591aa3f11ef8612cc153136262a, 0x3f9891a9a8b211efac950a0027000004, \'Silver\', \'Saree\', \'Jacket\', \'\', 50000),
(0x95994369aa3f11ef8612cc153136262a, 0x3f9891a9a8b211efac950a0027000004, \'Gold \', \'Saree\', \'Jacket\', \'Full Suits\', 100000),
(0xa9badb39aa3e11ef8612cc153136262a, 0x1415e1b4a8b211efac950a0027000004, \'asd\', \'adfa\', \'asd\', \'\', 1231),
(0xb438a7d5a98111ef8612cc153136262a, 0xac902193a8b111efac950a0027000004, \'Basic\', \'Bridal Makeup\', \'Facial\', \'\', 120000),
(0xc37ef387aa3f11ef8612cc153136262a, 0xe00e1dc1a8b111efac950a0027000004, \'Bronze\', \'Wedding Album\', \'\', \'\', 300000),
(0xc6f94118a98111ef8612cc153136262a, 0xac902193a8b111efac950a0027000004, \'Deluxe\', \'Bridal Makeup\', \'Group Makeup\', \'Facial\', 10000),
(0xdc4c4895aa3f11ef8612cc153136262a, 0xe00e1dc1a8b111efac950a0027000004, \'Silver\', \'Wedding Album\', \'Drone Photography\', \'\', 40000),
(0xeb95d723aa3e11ef8612cc153136262a, 0x1415e1b4a8b211efac950a0027000004, \'Deluxe\', \'Flower Bouquet\', \'\', \'\', 12000),
(0xf3158f05aa3f11ef8612cc153136262a, 0xe00e1dc1a8b111efac950a0027000004, \'Gold\', \'Wedding Album\', \'Drone Photography\', \'Photo Location\', 100000),
(0xfe756484aa3e11ef8612cc153136262a, 0x1415e1b4a8b211efac950a0027000004, \'Silver\', \'Sette back\', \'Flower Bouquet\', \'\', 15000);



INSERT INTO `dressdesignerpackages` (`packageID`, `variableCost`, `theme`, `demographic`) VALUES
(0x4fa7d5d6aa3f11ef8612cc153136262a, 50000, \'Kandyan\', \'Both\' ),
(0x7da01591aa3f11ef8612cc153136262a, 25000, \'Kandyan\', \'Both\' ),
(0x95994369aa3f11ef8612cc153136262a, 50000, \'Kandyan\', \'Both\' );

INSERT INTO `floristpackages` (`packageID`, `variableCost`, `flowerType`) VALUES
(0x189eec2faa3f11ef8612cc153136262a, 9000, \'Fresh\' ),
(0xa9badb39aa3e11ef8612cc153136262a, 12, \'Artificial\' ),
(0xeb95d723aa3e11ef8612cc153136262a, 4500, \'Artificial\' ),
(0xfe756484aa3e11ef8612cc153136262a, 5000, \'Artificial\' );

INSERT INTO `photographypackages` (`packageID`, `cameraCoverage`) VALUES
(0xc37ef387aa3f11ef8612cc153136262a, 3 ),
(0xdc4c4895aa3f11ef8612cc153136262a, 3 ),
(0xf3158f05aa3f11ef8612cc153136262a, 4 );

INSERT INTO `salonpackages` (`packageID`, `variableCost`, `demographic`) VALUES
(0x2a309042a98d11ef8612cc153136262a, 40000, \'Bride\' ),
(0x6574a1d6aa3d11ef8612cc153136262a, 100, \'Bride\' ),
(0xb438a7d5a98111ef8612cc153136262a, 10000, \'Both\' ),
(0xc6f94118a98111ef8612cc153136262a, 1300, \'Bride\' );


INSERT INTO `newvendornotifications` (`notificationID`, `title`, `message`, `reference`) VALUES
(0x77c13b6dacd411ef8612cc153136262a, \'New Vendor\', \'A new vendor has been added to the system.\', 0x77c10035acd411ef8612cc153136262a);

';
      $this->dbh->exec($SQL);;
    }

    public function down() {
      $SQL = "
      DELETE FROM photographyPackages;
      DELETE FROM floristPackages;
      DELETE FROM dressdesignerPackages;
      DELETE FROM salonPackages;
      DELETE FROM packages;
      DELETE FROM weddingbridegrooms;
      DELETE FROM bridegrooms;
      DELETE FROM wedding;
      DELETE FROM users;
      DELETE FROM vendors; ";
      $this->dbh->exec($SQL);
    }
}