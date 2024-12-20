<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241202102208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film ADD cinema_id INT NOT NULL');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22B4CB84B6 FOREIGN KEY (cinema_id) REFERENCES film (id)');
        $this->addSql('CREATE INDEX IDX_8244BE22B4CB84B6 ON film (cinema_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22B4CB84B6');
        $this->addSql('DROP INDEX IDX_8244BE22B4CB84B6 ON film');
        $this->addSql('ALTER TABLE film DROP cinema_id');
    }
}
