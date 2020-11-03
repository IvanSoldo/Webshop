<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103111506 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE store_settings ADD address_id INT NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD new_products_date DATE NOT NULL');
        $this->addSql('ALTER TABLE store_settings ADD CONSTRAINT FK_DB32DF3FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DB32DF3FF5B7AF75 ON store_settings (address_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE store_settings DROP FOREIGN KEY FK_DB32DF3FF5B7AF75');
        $this->addSql('DROP INDEX UNIQ_DB32DF3FF5B7AF75 ON store_settings');
        $this->addSql('ALTER TABLE store_settings DROP address_id, DROP email, DROP new_products_date');
    }
}
