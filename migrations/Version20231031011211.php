<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231031011211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft ADD creator_id_id INT NOT NULL, ADD user_id_id INT NOT NULL, ADD quantity INT NOT NULL, ADD status VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD token_id INT DEFAULT NULL, ADD token_contract_address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463CF05788E9 FOREIGN KEY (creator_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D9C7463CF05788E9 ON nft (creator_id_id)');
        $this->addSql('CREATE INDEX IDX_D9C7463C9D86650F ON nft (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463CF05788E9');
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C9D86650F');
        $this->addSql('DROP INDEX IDX_D9C7463CF05788E9 ON nft');
        $this->addSql('DROP INDEX IDX_D9C7463C9D86650F ON nft');
        $this->addSql('ALTER TABLE nft DROP creator_id_id, DROP user_id_id, DROP quantity, DROP status, DROP created_at, DROP updated_at, DROP token_id, DROP token_contract_address');
    }
}
