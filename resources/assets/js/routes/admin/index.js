import conteudosRoute from './conteudos';
import aplicativosRoutes from "./aplicativos";
import tiposRoutes from "./tipos";
import tagsRoutes from './tags';
import usuariosRoutes from './usuarios';
import licencasRoutes from './licencas';
import componentesRoutes from './componentes';
import optionsRoutes from './options';
import NewAdmin from "../../pages/NewAdmin.vue";
import rolesRoutes from './roles';
import canaisRoutes from './canais';
import contatoRoutes from './contato';
import categoriasRoutes from './categorias';

const childrenRoutes = [];

childrenRoutes.push(...conteudosRoute);
childrenRoutes.push(...aplicativosRoutes);
childrenRoutes.push(...tiposRoutes);
childrenRoutes.push(...tagsRoutes);
childrenRoutes.push(...usuariosRoutes);
childrenRoutes.push(...licencasRoutes);
childrenRoutes.push(...componentesRoutes);
childrenRoutes.push(...optionsRoutes);
childrenRoutes.push(...rolesRoutes);
childrenRoutes.push(...canaisRoutes);
childrenRoutes.push(...contatoRoutes);
childrenRoutes.push(...categoriasRoutes);


const newAdminRoutes = {
    path: "/painel",
    component: NewAdmin,
    name: 'index_panel',
    meta: {
        requiresAuth: true,
        title: "Inicio"
    },
    children: childrenRoutes
};

export default newAdminRoutes;
