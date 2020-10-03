GRANT ALL PRIVILEGES ON *.* TO 'docker'@'localhost' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON *.* TO 'docker'@'%' WITH GRANT OPTION;
DROP DATABASE IF EXISTS FORHEALTH;
CREATE DATABASE FORHEALTH;
USE FORHEALTH;
CREATE TABLE TBL_TIPO_USUARIO (
    tipo_id INT NOT NULL AUTO_INCREMENT,
    tipo_descricao VARCHAR(255) NOT NULL,

    CONSTRAINT tipo_pk PRIMARY KEY(tipo_id)
);
INSERT INTO TBL_TIPO_USUARIO (tipo_id, tipo_descricao) VALUES (1, 'ADMINISTRADOR');
INSERT INTO TBL_TIPO_USUARIO (tipo_id, tipo_descricao) VALUES (2, 'MÉDICO');
INSERT INTO TBL_TIPO_USUARIO (tipo_id, tipo_descricao) VALUES (3, 'PACIENTE');
CREATE TABLE  TBL_USUARIO (
    usr_id INT NOT NULL AUTO_INCREMENT,
    usr_cpf VARCHAR(20) NOT NULL,
    usr_senha VARCHAR(255) NOT NULL,
    usr_ativo BOOLEAN DEFAULT TRUE,
    usr_id_TIPO_USUARIO INT NOT NULL,
    CONSTRAINT usr_unique_cpf UNIQUE(usr_cpf),
    CONSTRAINT usr_pk PRIMARY KEY(usr_id),
    CONSTRAINT usr_fk_tipo FOREIGN KEY(usr_id_TIPO_USUARIO) REFERENCES TBL_TIPO_USUARIO(tipo_id)
);
INSERT INTO TBL_USUARIO (usr_id, usr_cpf, usr_senha, usr_ativo, usr_id_TIPO_USUARIO) VALUES (1, '140.526.066.12', 'admin', 1, 1);
INSERT INTO TBL_USUARIO (usr_id, usr_cpf, usr_senha, usr_ativo, usr_id_TIPO_USUARIO) VALUES (2, '281.701.480-49', 'med', 1, 2);
CREATE TABLE TBL_PACIENTE (
    pac_id INT NOT NULL AUTO_INCREMENT,
    pac_nome VARCHAR(255) NOT NULL,
    pac_uf VARCHAR(255) NOT NULL,
    pac_cidade VARCHAR(255) NOT NULL,
    pac_logradouro VARCHAR(255) NOT NULL,
    pac_bairro VARCHAR(255) NOT NULL,
    pac_numero_casa VARCHAR(255) NOT NULL,
    pac_telefone VARCHAR(20) NOT NULL,
    pac_id_USUARIO INT NOT NULL,

    CONSTRAINT pac_unique_usuario UNIQUE(pac_id_USUARIO),
    CONSTRAINT pac_pk PRIMARY KEY(pac_id),
    CONSTRAINT pac_fk_usr FOREIGN KEY(pac_id_USUARIO) REFERENCES TBL_USUARIO(usr_id)
);
CREATE TABLE TBL_MEDICO (
    med_id INT NOT NULL AUTO_INCREMENT,
    med_nome VARCHAR(255) NOT NULL,
    med_crm VARCHAR(20) NOT NULL,
    med_especialidade VARCHAR(255) NOT NULL,
    med_id_USUARIO INT NOT NULL,

    CONSTRAINT med_unique_crm UNIQUE(med_crm),
    CONSTRAINT med_unique_usuario UNIQUE(med_id_USUARIO),
    CONSTRAINT dtr_pk PRIMARY KEY(med_id),
    CONSTRAINT med_fk_usr FOREIGN KEY(med_id_USUARIO) REFERENCES TBL_USUARIO(usr_id)
);
INSERT INTO TBL_MEDICO (med_id, med_nome, med_crm, med_especialidade, med_id_USUARIO) VALUES (1, 'Dr. Luis', '234524', 'Neurologista', 2);