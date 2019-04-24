const state = {
    conteudos: [],
    paginator:{},
    conteudo:{},
    canal:{},
    sidebar:{},
    categories:[],
    temas:[],
    disciplinas:[],
    components:[],
    niveis:[],
    menssage: '',
    title: '',
    show:false, 
    isLogged: !!localStorage.token,
    error: false
}

export default state