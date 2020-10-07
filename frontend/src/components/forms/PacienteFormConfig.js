export default {
    title: "Cadastro de pacientes",
    fields: [
        {
            name: 'nome',
            type: 'text',
            label: 'Nome',
            rules: [val => val.length>0 || 'Preencha o nome']
        },
        {
            name: 'uf',
            type: 'text',
            label: 'Estado',
            rules: [val => val.length>0 || 'Preencha o estado']
        },
        {
            name: 'cidade',
            type: 'text',
            label: 'Cidade',
            rules: [val => val.length>0 || 'Preencha a cidade']
        },
        {
            name: 'logradouro',
            type: 'text',
            label: 'Logradouro',
            rules: [val => val.length>0 || 'Preencha o Logradouro']
        },
        {
            name: 'bairro',
            type: 'text',
            label: 'Bairro',
            rules: [val => val.length>0 || 'Preencha o bairro']
        },
        {
            name: 'numero_casa',
            type: 'text',
            label: 'Número da casa',
            rules: [val => val.length>0 || 'Preencha o número da casa']
        },
        {
            name: 'telefone',
            type: 'text',
            label: 'Celular',
            rules: [val => val.length>15 || 'Preencha o telefone'],
            mask: '(##) # ####-####'
        }
    ]
}