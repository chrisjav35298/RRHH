<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250504182639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE departamento (id INT AUTO_INCREMENT NOT NULL, ubicacion_id INT DEFAULT NULL, jefe_id INT DEFAULT NULL, nombre VARCHAR(50) DEFAULT NULL, INDEX IDX_40E497EB57E759E8 (ubicacion_id), INDEX IDX_40E497EB6919CBC2 (jefe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE empleado (id INT AUTO_INCREMENT NOT NULL, puesto_id INT DEFAULT NULL, jefe_id INT DEFAULT NULL, departamento_id INT DEFAULT NULL, empleado_id INT DEFAULT NULL, apellido VARCHAR(50) DEFAULT NULL, nombre VARCHAR(50) DEFAULT NULL, email VARCHAR(100) DEFAULT NULL, telefono INT DEFAULT NULL, fecha_ingreso DATE DEFAULT NULL, salario NUMERIC(8, 2) DEFAULT NULL, comision NUMERIC(8, 2) DEFAULT NULL, INDEX IDX_D9D9BF525035E9DA (puesto_id), INDEX IDX_D9D9BF526919CBC2 (jefe_id), INDEX IDX_D9D9BF525A91C08D (departamento_id), INDEX IDX_D9D9BF52952BE730 (empleado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE historial_puesto (id INT AUTO_INCREMENT NOT NULL, empleado_id INT DEFAULT NULL, puesto_id INT DEFAULT NULL, departamento_id INT DEFAULT NULL, fecha_inicio DATE NOT NULL, fecha_fin DATE DEFAULT NULL, INDEX IDX_405C765C952BE730 (empleado_id), INDEX IDX_405C765C5035E9DA (puesto_id), INDEX IDX_405C765C5A91C08D (departamento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE pais (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(25) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE provincia (id INT AUTO_INCREMENT NOT NULL, pais_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, INDEX IDX_D39AF213C604D5C6 (pais_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE puesto (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) DEFAULT NULL, salario_minimo NUMERIC(8, 0) DEFAULT NULL, salario_maximo NUMERIC(8, 0) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ubicacion (id INT AUTO_INCREMENT NOT NULL, provincia_id INT DEFAULT NULL, calle VARCHAR(50) DEFAULT NULL, codigo_postal VARCHAR(15) DEFAULT NULL, ciudad VARCHAR(100) DEFAULT NULL, INDEX IDX_DC158CB84E7121AF (provincia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE departamento ADD CONSTRAINT FK_40E497EB57E759E8 FOREIGN KEY (ubicacion_id) REFERENCES ubicacion (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE departamento ADD CONSTRAINT FK_40E497EB6919CBC2 FOREIGN KEY (jefe_id) REFERENCES empleado (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF525035E9DA FOREIGN KEY (puesto_id) REFERENCES puesto (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF526919CBC2 FOREIGN KEY (jefe_id) REFERENCES empleado (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF525A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF52952BE730 FOREIGN KEY (empleado_id) REFERENCES empleado (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE historial_puesto ADD CONSTRAINT FK_405C765C952BE730 FOREIGN KEY (empleado_id) REFERENCES empleado (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE historial_puesto ADD CONSTRAINT FK_405C765C5035E9DA FOREIGN KEY (puesto_id) REFERENCES puesto (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE historial_puesto ADD CONSTRAINT FK_405C765C5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE provincia ADD CONSTRAINT FK_D39AF213C604D5C6 FOREIGN KEY (pais_id) REFERENCES pais (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ubicacion ADD CONSTRAINT FK_DC158CB84E7121AF FOREIGN KEY (provincia_id) REFERENCES provincia (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE departamento DROP FOREIGN KEY FK_40E497EB57E759E8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE departamento DROP FOREIGN KEY FK_40E497EB6919CBC2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF525035E9DA
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF526919CBC2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF525A91C08D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF52952BE730
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE historial_puesto DROP FOREIGN KEY FK_405C765C952BE730
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE historial_puesto DROP FOREIGN KEY FK_405C765C5035E9DA
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE historial_puesto DROP FOREIGN KEY FK_405C765C5A91C08D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE provincia DROP FOREIGN KEY FK_D39AF213C604D5C6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ubicacion DROP FOREIGN KEY FK_DC158CB84E7121AF
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE departamento
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE empleado
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE historial_puesto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pais
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE provincia
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE puesto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ubicacion
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
