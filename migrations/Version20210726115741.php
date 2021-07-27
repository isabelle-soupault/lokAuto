<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210726115741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rental ADD users_id INT NOT NULL');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT FK_1619C27D67B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_1619C27D67B3B43D ON rental (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rental DROP FOREIGN KEY FK_1619C27D67B3B43D');
        $this->addSql('DROP INDEX IDX_1619C27D67B3B43D ON rental');
        $this->addSql('ALTER TABLE rental DROP users_id');
    }
}
