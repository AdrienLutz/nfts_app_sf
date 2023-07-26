<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230724100411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nft (id INT AUTO_INCREMENT NOT NULL, useradd_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, valeur DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, INDEX IDX_D9C7463C5B66C763 (useradd_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proprietaire_nft (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nft_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_246C432FA76ED395 (user_id), INDEX IDX_246C432FE813668D (nft_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C5B66C763 FOREIGN KEY (useradd_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE proprietaire_nft ADD CONSTRAINT FK_246C432FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE proprietaire_nft ADD CONSTRAINT FK_246C432FE813668D FOREIGN KEY (nft_id) REFERENCES nft (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C5B66C763');
        $this->addSql('ALTER TABLE proprietaire_nft DROP FOREIGN KEY FK_246C432FA76ED395');
        $this->addSql('ALTER TABLE proprietaire_nft DROP FOREIGN KEY FK_246C432FE813668D');
        $this->addSql('DROP TABLE nft');
        $this->addSql('DROP TABLE proprietaire_nft');
    }
}
