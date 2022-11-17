const conteudosPorAnoOptions = {
  plotOptions: {
    bar: {
      borderRadius: 4,
      horizontal: true,
    },
  },
  chart: {
    id: "vuechart-conteudos",
    height: 350,
    // width: "100%",
    type: "bar",
  },

  stroke: {
    curve: "smooth",
  },
  fill: {
    opacity: 0.8,
  },
  dataLabels: {
    enabled: false,
    positions: top,
  },
  xaxis: {
    categories: [],
  },
};

export { conteudosPorAnoOptions };
