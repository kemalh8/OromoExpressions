<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103092505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, nft_id_id INT NOT NULL, seller_id_id INT NOT NULL, buyer_id_id INT NOT NULL, wallet_id_id INT NOT NULL, transaction_date DATE NOT NULL, transaction_amount NUMERIC(10, 0) NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_723705D138B5C0F4 (nft_id_id), INDEX IDX_723705D1DF4C85EA (seller_id_id), INDEX IDX_723705D1881D19F2 (buyer_id_id), INDEX IDX_723705D1F43F82D (wallet_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D138B5C0F4 FOREIGN KEY (nft_id_id) REFERENCES nft (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1DF4C85EA FOREIGN KEY (seller_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1881D19F2 FOREIGN KEY (buyer_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F43F82D FOREIGN KEY (wallet_id_id) REFERENCES wallet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D138B5C0F4');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1DF4C85EA');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1881D19F2');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F43F82D');
        $this->addSql('DROP TABLE transaction');
    }
}
