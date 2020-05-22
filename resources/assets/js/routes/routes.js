import canalRoutes from "./canalRoutes";
import usuarioRoutes from "./usuarioRoutes";
import adminRoutes from "./adminRoutes";
import { homeRoute, galeriaRoute, sobreRoute }  from "./singleRoutes";
// import newAdminRoutes from "./admin";

const routes = [
  homeRoute,
  galeriaRoute,
  sobreRoute,
  adminRoutes,
  canalRoutes,
  usuarioRoutes
];

export default routes;
