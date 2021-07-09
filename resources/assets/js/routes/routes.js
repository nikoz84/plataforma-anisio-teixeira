import canalRoutes from "./canalRoutes";
import usuarioRoutes from "./usuarioRoutes";
import adminRoutes from "./adminRoutes";
import { 
  homeRoute, galeriaRoute, sobreRoute, ipesRoute, 
  rotinasRoute, advancedSearch, praticasInspiradoras, canalAT }  from "./singleRoutes";

const routes = [
  homeRoute,
  praticasInspiradoras,
  canalAT,
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
