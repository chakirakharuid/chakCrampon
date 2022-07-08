<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427175750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_ligne ADD produits_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande_ligne ADD CONSTRAINT FK_6E980440CD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id)');
        $this->addSql('CREATE INDEX IDX_6E980440CD11A2CF ON commande_ligne (produits_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_ligne DROP FOREIGN KEY FK_6E980440CD11A2CF');
        $this->addSql('DROP INDEX IDX_6E980440CD11A2CF ON commande_ligne');
        $this->addSql('ALTER TABLE commande_ligne DROP produits_id');
    }
}
