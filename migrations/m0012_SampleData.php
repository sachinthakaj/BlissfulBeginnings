<?php

class m0012_SampleData {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = 'INSERT INTO `vendors` (`vendorID`, `email`, `password`, `businessName`, `typeID`, `contact`, `address`,  `description`, `rating`, `imgSrc`, `websiteLink`, `vendorstate`) VALUES
(0x1415e1b4a8b211efac950a0027000004, \'kamalflora@gmail.com\', \'$2y$10$cOTf5/ccPqIFGCAWKMZ.zui/6gqYcKj.HRSUuOn/J8r8qh9tpXoB6\', \'Kamal Flora\', \'Florist\', \'0711234566\', \'127,main street,colombo\', \'Expertly crafting stunning floral arrangements to make your wedding day beautifully unforgettable.\', 0, NULL, \'kamal.lk\', \'accepted\'),
(0x2119fcd7ad5111ef849640c2ba135079, \'punsaranie@gmail.com\', \'$2y$10$Rj0SZaKBwt3hc3JPsvAPmuvNhjJtPLsgu7E/gKPToKMpNJpdXuLAC\', \'Punsaranie Floraists\', \'Florist\', \'0712345234\', \'56, Goadagedara Road, Ragama\', \'Expertly crafting stunning floral arrangements to make your wedding day beautifully unforgettable.\', 0, NULL, \'punsaranie.lk\', \'accepted\'),
(0x3f9891a9a8b211efac950a0027000004, \'hasinifashion@gmail.com\', \'$2y$10$lrC1m.snOE.8neexlOMj9utWdoGlXhhZaxYJr.7VurFzG8uEep6Fm\', \'Hasini Fashion\', \'Dress Designer\', \'0711234596\', \'130,main street,colombo\', \'Dress designers for weddings specialize in creating elegant, customized bridal attire, ensuring each piece reflects the brides unique style and vision.\', 0, NULL, \'hasini.lk\', \'new\'),
(0x46adb656ad5011ef849640c2ba135079, \'amalka@gmail.com\', \'$2y$10$Almhi8Cx6qBVYi.XSWdYy.L8O5rbpfzx/oF2OxyfYjY.NJZG0ZdKi\', \'Amalka Florists\', \'Florist\', \'0965456756\', \'54, Kandy Road, Wattala\', \'Expertly crafting stunning floral arrangements to make your wedding day beautifully unforgettable.\', 0, NULL, \'amalka.lk\', \'accepted\'),
(0x51452f32ad4f11ef849640c2ba135079, \'tashmika@gmail.com\', \'$2y$10$jRQaJIym3lQRu4zNKKYTku/ISI.Uxlh3kpL01H8dZVCEgU9ncrqo6\', \'Tashmika Designers\', \'Dress Designer\', \'0898909765\', \'43, Dunuwila Road, Panadura\', \'Dress designers for weddings specialize in creating elegant, customized bridal attire, ensuring each piece reflects the brides unique style and vision.\', 0, NULL, \'tashmika.lk\', \'accepted\'),
(0x69db2f85ad5e11ef849640c2ba135079, \'ramani@gmail.com\', \'$2y$10$qo18AKadvEedqtWVODbMf.HqiREWRA/7NLryyoyfiFyjgkVxreeqy\', \'Ramani Flora\', \'Florist\', \'0678989009\', \'698, Pubudu Road, Kurunegala\', \'Flowers bring life, elegance, and romance to every wedding celebration\', 0, \'/public/assets/images/img6.jpg\', \'ramani.lk\', \'new\'),
(0x72dd8a67ad5111ef849640c2ba135079, \'himasha@gmail.com\', \'$2y$10$/ETM76Xu3NldSC3VVtmJB.pBjym4PZnfydX5OA3Wx.l.15tqadujW\', \'Himasha Flora\', \'Photographer\', \'0787898909\', \'67, Dissanayake Road, Homagama\', \'Expertly crafting stunning floral arrangements to make your wedding day beautifully unforgettable.\', 0, NULL, \'himasha.lk\', \'accepted\'),
(0x911de4cbad4e11ef849640c2ba135079, \'dumindidresses@gmail.com\', \'$2y$10$2F593dbGrsXlsXjOY3zXGOsLKin741XnuKu/xBcB4vMpr4hYyCaWy\', \'Dumindi Dress Designers\', \'Dress Designer\', \'0760798788\', \'32, Panadura Road, Matara\', \'Dress designers for weddings specialize in creating elegant, customized bridal attire, ensuring each piece reflects the brides unique style and vision.\', 0, NULL, \'dumindidressdesigners.lk\', \'accepted\'),
(0x913f8695ad4f11ef849640c2ba135079, \'ishadi@gmail.com\', \'$2y$10$.6BRzBvXmD5IILmFiZRFh.kQ1xI6dNLJP6MWPwcA05Y0f1T/guRFm\', \'Ishadi Designers\', \'Dress Designer\', \'0765432134\', \'43/A, Matara Road, Homagama\', \'Dress designers for weddings specialize in creating elegant, customized bridal attire, ensuring each piece reflects the brides unique style and vision.\', 0, NULL, \'ishadi.lk\', \'accepted\'),
(0x9ce578e8ad6011ef849640c2ba135079, \'yohani@gmail.com\', \'$2y$10$hPf6.YOW4XahzPwtrd5jVO9fIZLr3f/n1mTgFFQiz.88sgSdggmQ2\', \'Yohani\', \'Dress Designer\', \'0987678987\', \'56, Church Road, Kandy\', \'Our wedding dress is more than just attire—its a reflection of your love story, style, and personality.\', 0, \'/public/assets/images/img10.jpg\', \'yohani.lk\', \'new\'),
(0xac902193a8b111efac950a0027000004, \'sandalisalon@gmail.com\', \'$2y$10$tTpibYjUrCN.cV5/xVFPeeIKZ49uYadwCVgh2kOU/sueuniHdtSJq\', \'Sandali  Salon\', \'Salon\', \'0711234567\', \'123,main street,colombo\', \'Providing exceptional bridal beauty services to make you look flawless on your big day.\', 0, NULL, \'sandali.lk\', \'new\'),
(0xe00e1dc1a8b111efac950a0027000004, \'sakyastudio@gmail.com\', \'$2y$10$q0YLSwPvI3C8NP.zNe9wWeUEkwoVFbz3w0A5.qwAz1S3u7./HSLWq\', \'Sakya Studio\', \'Photographer\', \'0711234567\', \'124,main street,colombo\', \'Capturing timeless moments and turning your wedding memories into art.\', 0, NULL, \'sakya.lk\', \'new\');

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
(0x04513d46ad5511ef849640c2ba135079, 0x2119fcd7ad5111ef849640c2ba135079, \'Basic Blooms Package\', \'Bridal bouquet\', \'Two bridesmaid bouquets\', \'Small floral arrangement for the wedding altar\', 50000),
(0x189eec2faa3f11ef8612cc153136262a, 0x1415e1b4a8b211efac950a0027000004, \'Gold\', \'Flower Bouqet\', \'Sette Back\', \'Table Decoration\', 20000),
(0x1fdf1cdcad5f11ef849640c2ba135079, 0x51452f32ad4f11ef849640c2ba135079, \'Essential Elegance Package\', \'Basic embellishments\', \'Final gown delivery in protective packaging\', \'\', 150000),
(0x2a309042a98d11ef8612cc153136262a, 0xac902193a8b111efac950a0027000004, \'Elite Wedding\', \'Facial Treatments\', \'Manicures\', \'Pedicures\', 180000),
(0x3be1e9ecad5f11ef849640c2ba135079, 0x51452f32ad4f11ef849640c2ba135079, \'Signature Style Package\', \'Up to four fitting sessions\', \'Final gown delivery with preservation box\', \'\', 175000),
(0x46add449ad6011ef849640c2ba135079, 0x913f8695ad4f11ef849640c2ba135079, \'Signature Style Package\', \'Comprehensive design consultation for the bridal gown\', \'Up to four fitting sessions\', \'\', 1750000),
(0x4fa7d5d6aa3f11ef8612cc153136262a, 0x3f9891a9a8b211efac950a0027000004, \'Bronze\', \'Saree\', \'\', \'\', 50000),
(0x5c44de6cad5d11ef849640c2ba135079, 0x911de4cbad4e11ef849640c2ba135079, \'Essential Elegance Package\', \'One custom bridal gown design consultation\', \'Fabric selection and sourcing\', \'\', 150000),
(0x6014cc41ad5f11ef849640c2ba135079, 0x51452f32ad4f11ef849640c2ba135079, \'Couture Bridal Experience Package\', \'Hand-selected, luxury fabrics and materials\', \'Unlimited fitting sessions to ensure a perfect fit\', \'\', 200000),
(0x6574a1d6aa3d11ef8612cc153136262a, 0xac902193a8b111efac950a0027000004, \'Platinum\', \'Facial\', \'Beauty treatments\', \'\', 1400),
(0x66963c6dad6011ef849640c2ba135079, 0x913f8695ad4f11ef849640c2ba135079, \'Couture Bridal Experience Package\', \'Exclusive one-on-one consultation with the head designer\', \'Hand-selected, luxury fabrics and materials\', \'\', 60000),
(0x7da01591aa3f11ef8612cc153136262a, 0x3f9891a9a8b211efac950a0027000004, \'Silver\', \'Saree\', \'Jacket\', \'\', 50000),
(0x807584e7ad5511ef849640c2ba135079, 0x2119fcd7ad5111ef849640c2ba135079, \'Deluxe Floral Elegance Package\', \'Grooms boutonniere\', \'Up to four groomsmen boutonnieres\', \'Toss bouquet for the bride\', 75000),
(0x8a140adead5c11ef849640c2ba135079, 0x46adb656ad5011ef849640c2ba135079, \'Basic Blooms Package\', \'Two groomsmen boutonnieres\', \'Grooms boutonniere\', \'\', 50000),
(0x95994369aa3f11ef8612cc153136262a, 0x3f9891a9a8b211efac950a0027000004, \'Gold \', \'Saree\', \'Jacket\', \'Full Suits\', 100000),
(0x97207b50ad5d11ef849640c2ba135079, 0x911de4cbad4e11ef849640c2ba135079, \'Signature Style Package\', \'Up to four fitting sessions\', \'Custom veil design to match the gown\', \'\', 175000),
(0xa4489253ad5c11ef849640c2ba135079, 0x46adb656ad5011ef849640c2ba135079, \'Deluxe Floral Elegance Package\', \'Grooms boutonniere\', \'Up to four groomsmen boutonnieres\', \'\', 75000),
(0xa9badb39aa3e11ef8612cc153136262a, 0x1415e1b4a8b211efac950a0027000004, \'asd\', \'adfa\', \'asd\', \'\', 1231),
(0xb438a7d5a98111ef8612cc153136262a, 0xac902193a8b111efac950a0027000004, \'Basic\', \'Bridal Makeup\', \'Facial\', \'\', 120000),
(0xc301379cad5c11ef849640c2ba135079, 0x46adb656ad5011ef849640c2ba135079, \'Premium Luxe Floral Package\', \'Grooms boutonniere\', \'Large statement piece for the entrance\', \'\', 100000),
(0xc37ef387aa3f11ef8612cc153136262a, 0xe00e1dc1a8b111efac950a0027000004, \'Bronze\', \'Wedding Album\', \'\', \'\', 300000),
(0xc6f94118a98111ef8612cc153136262a, 0xac902193a8b111efac950a0027000004, \'Deluxe\', \'Bridal Makeup\', \'Group Makeup\', \'Facial\', 10000),
(0xc975c707ad5d11ef849640c2ba135079, 0x911de4cbad4e11ef849640c2ba135079, \'Couture Bridal Experience Package\', \'Unlimited fitting sessions to ensure a perfect fit\', \'Accessories design \', \'\', 200000),
(0xd685e489ad5f11ef849640c2ba135079, 0x913f8695ad4f11ef849640c2ba135079, \'Essential Elegance Package\', \'One custom bridal gown design consultation\', \'\', \'\', 150000),
(0xda6d4f77ad5511ef849640c2ba135079, 0x2119fcd7ad5111ef849640c2ba135079, \'Premium Luxe Floral Package\', \'Large statement piece for the entrance\', \'Elaborate ceremony floral installations\', \'\', 100000),
(0xdc4c4895aa3f11ef8612cc153136262a, 0xe00e1dc1a8b111efac950a0027000004, \'Silver\', \'Wedding Album\', \'Drone Photography\', \'\', 40000),
(0xeb95d723aa3e11ef8612cc153136262a, 0x1415e1b4a8b211efac950a0027000004, \'Deluxe\', \'Flower Bouquet\', \'\', \'\', 12000),
(0xf3158f05aa3f11ef8612cc153136262a, 0xe00e1dc1a8b111efac950a0027000004, \'Gold\', \'Wedding Album\', \'Drone Photography\', \'Photo Location\', 100000),
(0xfe756484aa3e11ef8612cc153136262a, 0x1415e1b4a8b211efac950a0027000004, \'Silver\', \'Sette back\', \'Flower Bouquet\', \'\', 15000);




INSERT INTO `dressdesignerpackages` (`packageID`, `variableCost`, `theme`, `demographic`) VALUES
(0x1fdf1cdcad5f11ef849640c2ba135079, 40000, \'Kandyan\', \'Both\'),
(0x3be1e9ecad5f11ef849640c2ba135079, 50000, \'Western\', \'\'),
(0x46add449ad6011ef849640c2ba135079, 50000, \'Western\', \'\'),
(0x4fa7d5d6aa3f11ef8612cc153136262a, 50000, \'Kandyan\', \'Both\'),
(0x5c44de6cad5d11ef849640c2ba135079, 40000, \'Western\', \'\'),
(0x6014cc41ad5f11ef849640c2ba135079, 60000, \'Western\', \'\'),
(0x66963c6dad6011ef849640c2ba135079, 200000, \'Western\', \'Both\'),
(0x7da01591aa3f11ef8612cc153136262a, 25000, \'Kandyan\', \'Both\'),
(0x95994369aa3f11ef8612cc153136262a, 50000, \'Kandyan\', \'Both\'),
(0x97207b50ad5d11ef849640c2ba135079, 55000, \'Kandyan\', \'\'),
(0xc975c707ad5d11ef849640c2ba135079, 60000, \'Western\', \'Both\'),
(0xd685e489ad5f11ef849640c2ba135079, 40000, \'Western\', \'\');

INSERT INTO `floristpackages` (`packageID`, `variableCost`, `flowerType`) VALUES
(0x04513d46ad5511ef849640c2ba135079, 10000, \'Fresh\'),
(0x189eec2faa3f11ef8612cc153136262a, 9000, \'Fresh\'),
(0x807584e7ad5511ef849640c2ba135079, 15000, \'Fresh\'),
(0x8a140adead5c11ef849640c2ba135079, 10000, \'Artificial\'),
(0xa4489253ad5c11ef849640c2ba135079, 15000, \'Artificial\'),
(0xa9badb39aa3e11ef8612cc153136262a, 12, \'Artificial\'),
(0xc301379cad5c11ef849640c2ba135079, 25000, \'Artificial\'),
(0xda6d4f77ad5511ef849640c2ba135079, 20000, \'Fresh\'),
(0xeb95d723aa3e11ef8612cc153136262a, 4500, \'Artificial\'),
(0xfe756484aa3e11ef8612cc153136262a, 5000, \'Artificial\');

INSERT INTO `photographypackages` (`packageID`, `cameraCoverage`) VALUES
(0xc37ef387aa3f11ef8612cc153136262a, 3 ),
(0xdc4c4895aa3f11ef8612cc153136262a, 3 ),
(0xf3158f05aa3f11ef8612cc153136262a, 4 );

INSERT INTO `salonpackages` (`packageID`, `variableCost`, `demographic`) VALUES
(0x2a309042a98d11ef8612cc153136262a, 40000, \'Bride\' ),
(0x6574a1d6aa3d11ef8612cc153136262a, 100, \'Bride\' ),
(0xb438a7d5a98111ef8612cc153136262a, 10000, \'Both\' ),
(0xc6f94118a98111ef8612cc153136262a, 1300, \'Bride\' );


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