<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181031175600 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, content_id INT NOT NULL, author VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5F9E962A84A0A3ED (content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A84A0A3ED FOREIGN KEY (content_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post CHANGE post_title post_title VARCHAR(50) NOT NULL, CHANGE post_text post_text VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE comments');
        $this->addSql('ALTER TABLE post CHANGE post_title post_title VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE post_text post_text LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
