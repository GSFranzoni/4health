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
INSERT INTO TBL_USUARIO (usr_id, usr_cpf, usr_senha, usr_ativo, usr_id_TIPO_USUARIO) VALUES (1, '140.526.066.12', '12345678', 1, 1);
INSERT INTO TBL_USUARIO (usr_id, usr_cpf, usr_senha, usr_ativo, usr_id_TIPO_USUARIO) VALUES (2, '281.701.480-49', '12345678', 1, 2);
INSERT INTO TBL_USUARIO (usr_id, usr_cpf, usr_senha, usr_ativo, usr_id_TIPO_USUARIO) VALUES (3, '841.243.640-75', '12345678', 1, 3);
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
INSERT INTO TBL_PACIENTE (pac_id, pac_nome, pac_uf, pac_cidade, pac_logradouro, pac_bairro, pac_numero_casa, pac_telefone, pac_id_USUARIO) VALUES(
    1, 'José', 'MG', 'Ubá', 'Rua Maria', 'Santana', '159', '6561561651', 3
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
CREATE TABLE TBL_ATENDIMENTO_SOLICITACAO (
	ats_id INT NOT NULL AUTO_INCREMENT,
    ats_id_PACIENTE INT NOT NULL,
	ats_id_MEDICO INT NOT NULL,
    ats_aceito BOOLEAN DEFAULT NULL,
    ats_data_atendimento DATETIME NOT NULL,
    CONSTRAINT ats_pk PRIMARY KEY(ats_id),
    CONSTRAINT ats_fk_pac FOREIGN KEY(ats_id_PACIENTE) REFERENCES TBL_PACIENTE(pac_id),
    CONSTRAINT ats_fk_med FOREIGN KEY(ats_id_MEDICO) REFERENCES TBL_MEDICO(med_id)
);
INSERT INTO TBL_ATENDIMENTO_SOLICITACAO (ats_id_PACIENTE, ats_id_MEDICO, ats_data_atendimento) VALUES (1, 1, '2020-10-06 20:00:00');
CREATE TABLE TBL_ATENDIMENTO (
	ate_id INT NOT NULL AUTO_INCREMENT,
    ate_id_ATENDIMENTO_SOLICITACAO INT NOT NULL,
    ate_finalizado DATETIME DEFAULT NULL,
    CONSTRAINT ate_pk PRIMARY KEY(ate_id),
    CONSTRAINT ate_fk_ats FOREIGN KEY(ate_id_ATENDIMENTO_SOLICITACAO) REFERENCES TBL_ATENDIMENTO_SOLICITACAO(ats_id)
);
CREATE TABLE TBL_EXAME (
	exa_id INT NOT NULL AUTO_INCREMENT,
    exa_nome VARCHAR(255) NOT NULL,
    exa_resultado VARCHAR(800) NOT NULL,
    exa_id_PACIENTE INT NOT NULL,
    exa_laudo VARCHAR(800),
    exa_data DATETIME NOT NULL,
    CONSTRAINT exa_pk PRIMARY KEY(exa_id),    
    CONSTRAINT exa_fk_pac FOREIGN KEY(exa_id_PACIENTE) REFERENCES TBL_PACIENTE(pac_id)
);
INSERT INTO TBL_EXAME(exa_nome, exa_resultado, exa_id_PACIENTE, exa_laudo, exa_data) VALUES (
    'Exame de sangue', 'Exame de sangueExame de sangueExame de sangue', 1, 'O paciente tem aids', '2020-10-06 20:00:00'
);