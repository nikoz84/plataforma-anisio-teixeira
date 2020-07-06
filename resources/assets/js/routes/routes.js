import canalRoutes from "./canalRoutes";
import usuarioRoutes from "./usuarioRoutes";
import adminRoutes from "./adminRoutes";
import { homeRoute, galeriaRoute, sobreRoute, ipesRoute, rotinasRoute }  from "./singleRoutes";

const routes = [
  homeRoute,
  galeriaRoute,
  sobreRoute,
  rotinasRoute,
  ipesRoute,
  adminRoutes,
  canalRoutes,
  usuarioRoutes
];

export default routes;
