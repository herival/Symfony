<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200502205639 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ranking DROP FOREIGN KEY FK_80B839D09D86650F');
        $this->addSql('ALTER TABLE ranking DROP FOREIGN KEY FK_80B839D0FE1F3F0B');
        $this->addSql('DROP INDEX IDX_80B839D0FE1F3F0B ON ranking');
        $this->addSql('DROP INDEX IDX_80B839D09D86650F ON ranking');
        $this->addSql('ALTER TABLE ranking ADD record_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, DROP record_id_id, DROP user_id_id');
        $this->addSql('ALTER TABLE ranking ADD CONSTRAINT FK_80B839D04DFD750C FOREIGN KEY (record_id) REFERENCES record (id)');
        $this->addSql('ALTER TABLE ranking ADD CONSTRAINT FK_80B839D0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_80B839D04DFD750C ON ranking (record_id)');
        $this->addSql('CREATE INDEX IDX_80B839D0A76ED395 ON ranking (user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ranking DROP FOREIGN KEY FK_80B839D04DFD750C');
        $this->addSql('ALTER TABLE ranking DROP FOREIGN KEY FK_80B839D0A76ED395');
        $this->addSql('DROP INDEX IDX_80B839D04DFD750C ON ranking');
        $this->addSql('DROP INDEX IDX_80B839D0A76ED395 ON ranking');
        $this->addSql('ALTER TABLE ranking ADD record_id_id INT NOT NULL, ADD user_id_id INT NOT NULL, DROP record_id, DROP user_id');
        $this->addSql('ALTER TABLE ranking ADD CONSTRAINT FK_80B839D09D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ranking ADD CONSTRAINT FK_80B839D0FE1F3F0B FOREIGN KEY (record_id_id) REFERENCES record (id)');
        $this->addSql('CREATE INDEX IDX_80B839D0FE1F3F0B ON ranking (record_id_id)');
        $this->addSql('CREATE INDEX IDX_80B839D09D86650F ON ranking (user_id_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
