const getInputError = (errors, attr) => {
  return { "has-error": errors[attr] && errors[attr].length > 0 };
};

module.exports = {
  getInputError
};
