<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102153548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft ADD category_id_id INT NOT NULL, ADD parent_nft_id INT NOT NULL, ADD child_nfts_id INT NOT NULL');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463CA700A54B FOREIGN KEY (parent_nft_id) REFERENCES nft (id)');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C162419C5 FOREIGN KEY (child_nfts_id) REFERENCES nft (id)');
        $this->addSql('CREATE INDEX IDX_D9C7463C9777D11E ON nft (category_id_id)');
        $this->addSql('CREATE INDEX IDX_D9C7463CA700A54B ON nft (parent_nft_id)');
        $this->addSql('CREATE INDEX IDX_D9C7463C162419C5 ON nft (child_nfts_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C9777D11E');
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463CA700A54B');
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C162419C5');
        $this->addSql('DROP INDEX IDX_D9C7463C9777D11E ON nft');
        $this->addSql('DROP INDEX IDX_D9C7463CA700A54B ON nft');
        $this->addSql('DROP INDEX IDX_D9C7463C162419C5 ON nft');
        $this->addSql('ALTER TABLE nft DROP category_id_id, DROP parent_nft_id, DROP child_nfts_id');
    }
}
