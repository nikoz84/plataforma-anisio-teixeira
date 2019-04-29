const helper = {
  serializeFormData(form) {
    const formData = new FormData(form);

    Object.keys(form).map(key => {
      if (form.hasOwnProperty(key)) {
        console.log(`{"${key}": ${form[key]}}`);
        formData.append(`"${key}"`, form[key]);
      }
    });
    return formData;
  }
};

export default {
  helper
};
