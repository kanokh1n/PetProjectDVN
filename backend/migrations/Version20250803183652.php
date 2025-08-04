<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250803183652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE project_info DROP CONSTRAINT fk_f218f94f166d1f9c
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX uniq_f218f94f166d1f9c
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_info RENAME COLUMN project_id TO projects_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_info ADD CONSTRAINT FK_F218F94F1EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_F218F94F1EDE0F55 ON project_info (projects_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE project_info DROP CONSTRAINT FK_F218F94F1EDE0F55
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_F218F94F1EDE0F55
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_info RENAME COLUMN projects_id TO project_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_info ADD CONSTRAINT fk_f218f94f166d1f9c FOREIGN KEY (project_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX uniq_f218f94f166d1f9c ON project_info (project_id)
        SQL);
    }
}
