<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210420023513 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE enchere');
        $this->addSql('DROP TABLE evenements');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE liste_commande');
        $this->addSql('DROP TABLE oeuvre_competition');
        $this->addSql('DROP TABLE participation_oeuvre');
        $this->addSql('DROP TABLE participer');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE votec');
        $this->addSql('DROP INDEX fkk_idpanier ON oeuvre');
        $this->addSql('DROP INDEX fk_oeuvre_portfolio ON oeuvre');
        $this->addSql('ALTER TABLE oeuvre ADD id INT AUTO_INCREMENT NOT NULL, ADD ref_id INT DEFAULT NULL, DROP ref, DROP fk_id_portfolio, DROP id_panier, CHANGE description description VARCHAR(255) NOT NULL, CHANGE date_ajout date_ajout DATE NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE21B741A9 FOREIGN KEY (ref_id) REFERENCES portfolio (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_35FE2EFE21B741A9 ON oeuvre (ref_id)');
        $this->addSql('DROP INDEX fk_idcodepromo ON panier');
        $this->addSql('DROP INDEX fk_id_user ON portfolio');
        $this->addSql('ALTER TABLE portfolio DROP id_user, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE date_creation date_creation DATE NOT NULL, CHANGE label laabel VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (idcomment INT AUTO_INCREMENT NOT NULL, idevenement INT NOT NULL, iduser INT NOT NULL, commentaire VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX fk_idevcoment (idevenement), PRIMARY KEY(idcomment)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE competition (ref_competition INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, theme VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_debut VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_fin VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(ref_competition)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE enchere (id_enchere INT NOT NULL, prixinit_enchere DOUBLE PRECISION DEFAULT NULL, date_enchere DATE NOT NULL, duree_enchere TIME DEFAULT NULL, coupant DOUBLE PRECISION DEFAULT NULL, id_user INT NOT NULL, id_oeuvre INT NOT NULL) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evenements (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, DateDebut DATE NOT NULL, DateFin DATE NOT NULL, lieu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nbreplaces INT NOT NULL, image VARCHAR(2555) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nbreparticipants INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE formation (id_formation INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prixph INT NOT NULL, contact VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(2555) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_formation)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE liste_commande (ref_commande INT AUTO_INCREMENT NOT NULL, id_panier INT NOT NULL, id INT NOT NULL, adresse_liv VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, INDEX fk_id_userpanier (id), INDEX fk_idpanier (id_panier), PRIMARY KEY(ref_commande)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oeuvre_competition (ref_oc INT AUTO_INCREMENT NOT NULL, Ref_Ov INT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image LONGBLOB NOT NULL, ref_competition INT NOT NULL, INDEX fk_ref_comp (ref_competition), INDEX fk_ov_CO (Ref_Ov), PRIMARY KEY(ref_oc)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participation_oeuvre (ref_competition INT NOT NULL, ref_oc INT NOT NULL, INDEX fk_ref_oc (ref_oc), PRIMARY KEY(ref_competition, ref_oc)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participer (id INT NOT NULL, idEvenement INT NOT NULL, iduser INT NOT NULL, INDEX fk_iduserevenemnt (iduser), INDEX fk_idparev (idEvenement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (id_reservation INT NOT NULL, id_formation INT NOT NULL, heure INT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX fk_idformation (id_formation), PRIMARY KEY(id_reservation)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, numero INT NOT NULL, age INT NOT NULL, image MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, addresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, role VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, UNIQUE INDEX email (email), UNIQUE INDEX username (username), UNIQUE INDEX numero (numero), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vote (id INT NOT NULL, id_user INT NOT NULL, id_evenement INT NOT NULL, type_vote INT NOT NULL, INDEX fk_iduservote (id_user), INDEX fk_idevenmentt (id_evenement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE votec (ref_oc INT NOT NULL, id_user_vote INT NOT NULL, INDEX vote_ibfk_2 (id_user_vote), PRIMARY KEY(ref_oc, id_user_vote)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE oeuvre MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE21B741A9');
        $this->addSql('DROP INDEX IDX_35FE2EFE21B741A9 ON oeuvre');
        $this->addSql('ALTER TABLE oeuvre DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE oeuvre ADD ref INT NOT NULL, ADD id_panier INT DEFAULT NULL, DROP id, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE date_ajout date_ajout DATE DEFAULT NULL, CHANGE image image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE ref_id fk_id_portfolio INT DEFAULT NULL');
        $this->addSql('CREATE INDEX fkk_idpanier ON oeuvre (id_panier)');
        $this->addSql('CREATE INDEX fk_oeuvre_portfolio ON oeuvre (fk_id_portfolio)');
        $this->addSql('ALTER TABLE oeuvre ADD PRIMARY KEY (ref)');
        $this->addSql('CREATE INDEX fk_idcodepromo ON panier (id_codepromo)');
        $this->addSql('ALTER TABLE portfolio ADD id_user INT NOT NULL, CHANGE id id INT NOT NULL, CHANGE date_creation date_creation DATETIME DEFAULT \'CURRENT_TIMESTAMP(6)\' NOT NULL, CHANGE laabel label VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('CREATE INDEX fk_id_user ON portfolio (id_user)');
    }
}
