export default {
    title: "Cadastro de Medicos",
    fields: [
        {
            name: 'nome',
            type: 'text',
            label: 'Nome',
            rules: [val => val.length>0 || 'Preencha o nome']
        },
        {
            name: 'crm',
            type: 'text',
            label: 'Crm',
            rules: [val => val.length>0 || 'Preencha o crm']
        },
        {
            name: 'especialidade',
            type: 'text',
            label: 'Especialidade',
            rules: [val => val.length>0 || 'Preencha a especialidade']
        }
    ]
}