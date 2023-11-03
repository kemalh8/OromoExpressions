<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102135047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463CDF4C85EA');
        $this->addSql('DROP INDEX IDX_D9C7463CDF4C85EA ON nft');
        $this->addSql('ALTER TABLE nft DROP seller_id_id');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD birthdate DATE DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD wallet_address VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft ADD seller_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463CDF4C85EA FOREIGN KEY (seller_id_id) REFERENCES seller (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D9C7463CDF4C85EA ON nft (seller_id_id)');
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name, DROP birthdate, DROP address, DROP wallet_address, DROP created_at, DROP updated_at');
    }
}
