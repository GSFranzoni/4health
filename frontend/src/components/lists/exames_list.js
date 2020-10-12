export default {
    columns: [
        {
            name: "actions",
            label: "Ações",
            align: "left"
        },
        {
            name: "nome",
            label: "Nome",
            field: "nome",
            align: "left",
            sortable: true
        },
        {
            name: "medico",
            label: "Médico",
            field: row => row.medico.nome,
            align: "left",
            sortable: true
        },
        {
            name: "paciente",
            label: "Paciente",
            field: row => row.paciente.nome,
            align: "left",
            sortable: true
        },
        {
            name: "data",
            label: "Data",
            field: "data",
            align: "left",
            sortable: true
        }
    ]
}
