function response(resp) {
  if (resp.status == 200 && resp.data.success) {
    return true;
  } else if (resp.status == 200 && resp.data.errors) {
    return false;
  } else {
    return false;
  }
}

async function goTo(nameRoute, slugClient) {
  this.$router.go({
    name: nameRoute,
    params: { slug: slugClient }
  });
}

module.exports = {
  response,
  goTo
};
