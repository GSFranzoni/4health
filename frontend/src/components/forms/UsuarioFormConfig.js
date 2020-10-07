export default {
    title: "Cadastro de usuários",
    fields: [
        {
            name: 'cpf',
            type: 'text',
            label: 'Cpf',
            rules: [ val => val && val.length > 13 || 'Preencha o cpf'],
            mask: '###.###.###-##'
        },
        {
            name: 'senha',
            type: 'password',
            label: 'Senha',
            rules: [val => val.length>7 || 'A senha precisa ter 8 caracteres ou mais']
        }
    ]
}