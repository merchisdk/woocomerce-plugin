jQuery(document).ready(function ($) {
  var embed = {
    featureImage: {},
    images: {},
    domain: { company: {} },
  };
  var allowedExtensions = {
    "image/jpeg": "jpeg",
    "image/jpg": "jpg",
    "image/png": "png",
  };
  function downloadMerchiImageReturnData(file) {
    var mimetype = file.mimetype() ? file.mimetype() : null,
      downloadSrc = "https://api.merchi.co/v6/product-public-file/download/",
      extension = mimetype ? allowedExtensions[mimetype] : null;
    return extension
      ? { src: `${downloadSrc}${file.id()}.${extension}` }
      : null;
  }

  function convertMerchiProductImages(merchiProduct) {
    return merchiProduct.images()
      ? merchiProduct.images().map(downloadMerchiImageReturnData)
      : [];
  }

  function convertedMerchiProducts(products) {
    var _products = [],
      i;
    if (products) {
      for (i = 0; i < products.length; i++) {
        var merchiProduct = products[i],
          merchiProductImages;
        if (merchiProduct.json && merchiProduct.json === "product") {
          merchiProductImages = convertMerchiProductImages(merchiProduct);
          _products.push({
            description: merchiProduct.description(),
            price: merchiProduct.unitPrice(),
            name: merchiProduct.name(),
            regular_price: merchiProduct.unitPrice(),
            images: merchiProductImages,
            sku: merchiProduct.id(),
          });
        }
      }
    }
    return { create: _products };
  }

  async function addProductsToDatabase(data) {
    // on fetch merchi products success pass them to the
    // "create_merchi_products" endpoint so that they can be saved
    // into the products table
    var products = data,
      meta = data.meta,
      msgName = meta.available === 1 ? "product" : "products",
      msg = `${meta.available} Merchi ${msgName} have been fetched and saved into products.`,
      _products = await convertedMerchiProducts(products);
    $.ajax({
      type: "post",
      url: create_merchi_products.ajax_url,
      data: {
        action: "create_merchi_products",
        products: _products,
        _ajax_nonce: create_merchi_products.nonce,
      },
      success: function (data) {
        alert(msg);
        $("#merchi-fetch-button").html("Fetch");
        $("#merchi-fetch-button").prop("disabled", false);
      },
      error: function (MLHttpRequest, textStatus, errorThrown) {
        console.log(errorThrown);
      },
    });
  }

  function fetchProductError(data, code) {
    alert(
      "There was an error fetching products from Merchi" +
        "Please check the console for more info."
    );
    console.error(data, code);
  }

  $("#merchi-fetch-button").click(function () {
    $("#merchi-fetch-button").html("Fetching...");
    $("#merchi-fetch-button").prop("disabled", true);
    MERCHI_SDK.products.get(addProductsToDatabase, fetchProductError, {
      embed: embed,
      inDomain: merchiObject.merchiStoreName,
    });
  });
});
