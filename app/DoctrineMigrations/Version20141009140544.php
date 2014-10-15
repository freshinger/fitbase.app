<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141009140544 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE order__order CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE order__order_audit CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE invoice__invoice CHANGE currency currency CHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE invoice__invoice_audit CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE basket__basket CHANGE currency currency CHAR(3) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE basket__basket CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE invoice__invoice CHANGE currency currency CHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE invoice__invoice_audit CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE order__order CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE order__order_audit CHANGE currency currency CHAR(3) DEFAULT NULL');
    }
}
