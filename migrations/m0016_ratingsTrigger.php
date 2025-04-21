<?php

class m0016_ratingsTrigger
{
    private $dbh;
    public function __construct($dbh)
    {
        $this->dbh = $dbh;
    }

    public function up()
    {
        $SQL = "
      CREATE TRIGGER update_vendor_rating_after_package_assignment_update
        AFTER UPDATE ON packageAssignment
        FOR EACH ROW
        BEGIN
            -- Only proceed if the rating was changed in the update
            IF OLD.rating <> NEW.rating OR (OLD.rating IS NULL AND NEW.rating IS NOT NULL) OR (OLD.rating IS NOT NULL AND NEW.rating IS NULL) THEN
                -- Update the vendor rating for the affected vendor
                UPDATE vendors v
                SET v.rating = (
                    -- Calculate the average rating for all packages of this vendor
                    SELECT AVG(pa.rating)
                    FROM packageAssignment pa
                    JOIN packages p ON pa.packageID = p.packageID
                    WHERE p.vendorID = (
                        -- Find the vendorID for the current package
                        SELECT p2.vendorID
                        FROM packages p2
                        WHERE p2.packageID = NEW.packageID
                    )
                );
            END IF;
        END
    ";
        $this->dbh->exec($SQL);
    }

    public function down()
    {
        $SQL = "
      DROP TABLE gallery; ";
        $this->dbh->exec($SQL);
    }
}
