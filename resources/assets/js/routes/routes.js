import canalRoutes from "./canalRoutes";
import usuarioRoutes from "./usuarioRoutes";
import adminRoutes from "./adminRoutes";
import { homeRoute, galeriaRoute, sobreRoute, ipesRoute, rotinasRoute, advancedSearch, praticasInspiradoras }  from "./singleRoutes";

const routes = [
  homeRoute,
  praticasInspiradoras,
  galeriaRoute,
  sobreRoute,
  rotinasRoute,
  ipesRoute,
  adminRoutes,
  advancedSearch,
  canalRoutes,
  usuarioRoutes
];

export default routes;
