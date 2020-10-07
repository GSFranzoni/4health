export default {
    title: "Solicitar atendimento",
    fields: [
        {
            name: 'data',
            type: 'date',
            label: 'Data',
            rules: ['date'],
            mask: 'date'
        },
        {
            name: 'horario',
            type: 'time',
            label: 'Horário',
            rules: ['time']
        }
    ]
}