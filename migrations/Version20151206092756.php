<?php

namespace Codeliner\CargoBackend\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151206092756 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cargo (tracking_id CHAR(36) NOT NULL COMMENT \'(DC2Type:cargo_tracking_id)\', route_specification_id INT DEFAULT NULL, itinerary_id INT DEFAULT NULL, origin VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3BEE5771C41C4191 (route_specification_id), UNIQUE INDEX UNIQ_3BEE577115F737B2 (itinerary_id), PRIMARY KEY(tracking_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE itinerary (id INT AUTO_INCREMENT NOT NULL, legs LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route_specification (id INT AUTO_INCREMENT NOT NULL, origin VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cargo ADD CONSTRAINT FK_3BEE5771C41C4191 FOREIGN KEY (route_specification_id) REFERENCES route_specification (id)');
        $this->addSql('ALTER TABLE cargo ADD CONSTRAINT FK_3BEE577115F737B2 FOREIGN KEY (itinerary_id) REFERENCES itinerary (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cargo DROP FOREIGN KEY FK_3BEE577115F737B2');
        $this->addSql('ALTER TABLE cargo DROP FOREIGN KEY FK_3BEE5771C41C4191');
        $this->addSql('DROP TABLE cargo');
        $this->addSql('DROP TABLE itinerary');
        $this->addSql('DROP TABLE route_specification');
    }
}
