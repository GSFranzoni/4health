export default {
    title: "Cadastro de exames",
    fields: [
        {
            name: 'nome',
            type: 'text',
            label: 'Nome',
            rules: [val => val.length>0 || 'Preencha o nome']
        },
        {
            name: 'resultado',
            type: 'textarea',
            label: 'Resultado',
            rules: [val => val.length>0 || 'Preencha o resultado']
        },
        {
            name: 'laudo',
            type: 'textarea',
            label: 'Laudo',
            rules: [val => val.length>0 || 'Preencha o laudo']
        },
        {
            name: 'data',
            type: 'date',
            label: 'Data',
            rules: ['date']
        },
        {
            name: 'horario',
            type: 'time',
            label: 'Horário',
            rules: ['time']
        }
    ]
}