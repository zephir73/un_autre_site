#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Client
#------------------------------------------------------------

CREATE TABLE Client(
        ID_Client          int (11) Auto_increment  NOT NULL ,
        Nom_Client         Varchar (100) ,
        Prenom_Client      Varchar (100) ,
        Nb_Tel_Fix_Client  Varchar (100) ,
        Nb_Tel_Port_Client Varchar (100) ,
        Adresse_Client     Varchar (100) ,
        Ville_Client       Varchar (100) ,
        Cp_Client          Varchar (100) ,
        Email_Client       Varchar (100) ,
        Mdp_Client         Varchar (100) ,
        ID_Droit           Int ,
        PRIMARY KEY (ID_Client )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Article
#------------------------------------------------------------

CREATE TABLE Article(
        ID_Article          int (11) Auto_increment  NOT NULL ,
        Nom_Article         Varchar (100) ,
        Description_Article Varchar (100) ,
        Prix_Article        Varchar (100) ,
        Tva_Article         Varchar (25) ,
        Chemin_Image        Varchar (100) ,
        ID_Categorie        Int ,
        PRIMARY KEY (ID_Article )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Categorie
#------------------------------------------------------------

CREATE TABLE Categorie(
        ID_Categorie  int (11) Auto_increment  NOT NULL ,
        Nom_Categorie Varchar (100) ,
        PRIMARY KEY (ID_Categorie )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Droit
#------------------------------------------------------------

CREATE TABLE Droit(
        ID_Droit           int (11) Auto_increment  NOT NULL ,
        Autorisation_Droit Varchar (100) ,
        PRIMARY KEY (ID_Droit )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Commande
#------------------------------------------------------------

CREATE TABLE Commande(
        ID_Commande      int (11) Auto_increment  NOT NULL ,
        Date_Commande    Varchar (100) ,
        Total_Commande   Varchar (100) ,
        ID_Client        Int ,
        ID_Etat_Commande Int ,
        ID_Transporteur  Int ,
        PRIMARY KEY (ID_Commande )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Facture
#------------------------------------------------------------

CREATE TABLE Facture(
        ID_Facture        int (11) Auto_increment  NOT NULL ,
        Date_Facture      Varchar (100) ,
        Total_Facture     Varchar (100) ,
        Adresse_Facture   Varchar (100) ,
        Adresse_Livraison Varchar (100) ,
        ID_Commande       Int ,
        PRIMARY KEY (ID_Facture )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Etat_Commande
#------------------------------------------------------------

CREATE TABLE Etat_Commande(
        ID_Etat_Commande int (11) Auto_increment  NOT NULL ,
        Etat_Commande    Varchar (100) ,
        PRIMARY KEY (ID_Etat_Commande )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Transporteur
#------------------------------------------------------------

CREATE TABLE Transporteur(
        ID_Transporteur   int (11) Auto_increment  NOT NULL ,
        Nom_Transporteur  Varchar (100) ,
        Prix_Transporteur Varchar (100) ,
        PRIMARY KEY (ID_Transporteur )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Stock
#------------------------------------------------------------

CREATE TABLE Stock(
        ID_Stock   int (11) Auto_increment  NOT NULL ,
        Qte_Stock  Varchar (100) ,
        ID_Article Int ,
        PRIMARY KEY (ID_Stock )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Composer
#------------------------------------------------------------

CREATE TABLE Composer(
        Nb_Article   Varchar (100) ,
        Prix_Article Varchar (100) ,
        Tva_Article  Varchar (25) ,
        ID_Article   Int NOT NULL ,
        ID_Commande  Int NOT NULL ,
        PRIMARY KEY (ID_Article ,ID_Commande )
)ENGINE=InnoDB;

ALTER TABLE Client ADD CONSTRAINT FK_Client_ID_Droit FOREIGN KEY (ID_Droit) REFERENCES Droit(ID_Droit);
ALTER TABLE Article ADD CONSTRAINT FK_Article_ID_Categorie FOREIGN KEY (ID_Categorie) REFERENCES Categorie(ID_Categorie);
ALTER TABLE Commande ADD CONSTRAINT FK_Commande_ID_Client FOREIGN KEY (ID_Client) REFERENCES Client(ID_Client);
ALTER TABLE Commande ADD CONSTRAINT FK_Commande_ID_Etat_Commande FOREIGN KEY (ID_Etat_Commande) REFERENCES Etat_Commande(ID_Etat_Commande);
ALTER TABLE Commande ADD CONSTRAINT FK_Commande_ID_Transporteur FOREIGN KEY (ID_Transporteur) REFERENCES Transporteur(ID_Transporteur);
ALTER TABLE Facture ADD CONSTRAINT FK_Facture_ID_Commande FOREIGN KEY (ID_Commande) REFERENCES Commande(ID_Commande);
ALTER TABLE Stock ADD CONSTRAINT FK_Stock_ID_Article FOREIGN KEY (ID_Article) REFERENCES Article(ID_Article);
ALTER TABLE Composer ADD CONSTRAINT FK_Composer_ID_Article FOREIGN KEY (ID_Article) REFERENCES Article(ID_Article);
ALTER TABLE Composer ADD CONSTRAINT FK_Composer_ID_Commande FOREIGN KEY (ID_Commande) REFERENCES Commande(ID_Commande);


#---------------------------------------------------------------

# Insert: des enregistrements sur les table Droit, Etat_Commande et Client

# pour eviter quelque probleme d_enregistrement

#---------------------------------------------------------------

INSERT INTO Droit ( ID_Droit, Autorisation_Droit) VALUE (NULL, 'Client');

INSERT INTO Droit ( ID_Droit, Autorisation_Droit) VALUE (NULL,'Admin');


INSERT INTO Etat_Commande (ID_Etat_Commande, Etat_Commande) VALUE (NULL, 'Payer');

INSERT INTO Etat_Commande (ID_Etat_Commande, Etat_Commande) VALUE (NULL, 'Pas payer');

INSERT INTO Etat_Commande (ID_Etat_Commande, Etat_Commande) VALUE (NULL, 'En cours');


INSERT INTO `Client` (`ID_Client`, `Nom_Client`, `Prenom_Client`, `Nb_Tel_Fix_Client`, `Nb_Tel_Port_Client`, `Adresse_Client`, `Ville_Client`, `Cp_Client`, `Email_Client`, `Mdp_Client`, `ID_Droit`) VALUES (NULL, 'Cyprien', 'Didier', '+330479364826', '+330479364826', 'Le chef lieu', 'Betton-bettonnet', '73390', 'didier.cyprien@gmail.com', 'mdp', '2');

