jQuery(document).ready(function ($) {
  var limit = 25;
  var available = 0;
  var totalAvailable = 0;
  var allProducts = [];
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
      downloadSrc = $('#merchi_base_url').length ? $('#merchi_base_url').val() + "v6/product-public-file/download/" : "https://api.merchi.co/v6/product-public-file/download/",
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
      i,
      j,
      arraySize = limit,
      arrayOfProductArrays = [];
    if (products) {
      for (i = 0; i < products.length; i++) {
        var merchiProduct = products[i],
          merchiProductImages;
        if (merchiProduct.json && merchiProduct.json === "product") {
          merchiProductImages = convertMerchiProductImages(merchiProduct);
		  // console.log(merchiProductImages);
          _products.push({
            description: merchiProduct.description(),
            price: merchiProduct.unitPrice(),
            name: merchiProduct.name(),
            regular_price: merchiProduct.unitPrice(),
            images: merchiProductImages,
            sku: merchiProduct.id(),
			      merchi_updated: merchiProduct.updated(),
          });
        }
      }
    }
    // for (j = 0; j < _products.length; j += arraySize) {
    //   arrayOfProductArrays.push(_products.slice(j, j + arraySize));
    // }
    return _products;
  }

  function injectProductsIntoDB(products) {
    $("#merchi-sync-products").prop("disabled", true);
    var msg = `Merchi products have been fetched and saved into products.`;
    $.ajax({
      type: "post",
      url: create_merchi_products.ajax_url,
      data: {
        action: "create_merchi_products",
        products: products,
        _ajax_nonce: create_merchi_products.nonce,
      },
      success: function (_data) {
        $("#merchi-fetch-button").html("Fetch");
        $("#merchi-fetch-button").prop("disabled", false);
        $("#merchi-progress").val(0);
        $("#merchi-sync-products").prop("disabled", false);
        toast();
        return;
      },
      error: function (MLHttpRequest, textStatus, errorThrown) {
        console.error(errorThrown);
        $("#merchi-fetch-button").html("Fetch");
        $("#merchi-fetch-button").prop("disabled", false);
        $("#merchi-progress").val(0);
        $("#merchi-sync-products").prop("disabled", false);
        return;
      },
    });
  }
  
  var merchiProducts = [];
  function selectMerchiProducts(products) {
    var msg = `Merchi products have been fetched and saved into products.`;
	  merchiProducts = products;
    $.ajax({
      type: "post",
      url: create_merchi_products.ajax_url,
      data: {
        action: "select_merchi_products",
        products: products,
        _ajax_nonce: create_merchi_products.nonce,
      },
      success: function (_data) {
        // console.log(_data);
		if(_data != '' ) {
			$('.plugin-table').html(_data);
			$('.plugin-table-wrap').show();
		}
		else {
			$('.plugin-table-wrap').hide();
		}
      },
      error: function (MLHttpRequest, textStatus, errorThrown) {
        console.error(errorThrown);
/*        $("#merchi-fetch-button").html("Fetch");
        $("#merchi-fetch-button").prop("disabled", false);
        $("#merchi-progress").val(0);
        return;*/
      },
    });
  }
  
  $("#merchi-sync-products").click(function () {
    var skus = [];
    var products = [];
    $('.plugin-table .merchi_checkbox').each(function (index, checkBox) {
      if($(checkBox).is(':checked')) {
        skus.push($(checkBox).data('sku'));
      }
    });
    $(merchiProducts.create).each(function (index, product) {
      if($.inArray(product['sku'], skus) !== -1) {
        products.push(product);
      }
    });
    totalAvailable = products.length;
    if( products.length > 0 ) {
      injectProductsIntoDB({ create: products });
    }
  });

  $("#merchi-all-products").change(function () {
    BulkChange();
  });
  $("#merchi-new-products").change(function () {
    BulkChange();
  });
  $("#merchi-new-data").change(function () {
    BulkChange();
  });

  function BulkChange() {
    $('.plugin-table .merchi_checkbox').each(function (index, checkBox) {
      if($(checkBox).data('status') == 'new-product') {
        if($('#merchi-all-products').is(':checked') || $('#merchi-new-products').is(':checked')) {
          $(checkBox).prop('checked', true);
        }
        else {
          $(checkBox).prop('checked', false);
        }
      }
      if($(checkBox).data('status') == 'new-data') {
        if($('#merchi-all-products').is(':checked') || $('#merchi-new-data').is(':checked')) {
          $(checkBox).prop('checked', true);
        }
        else {
          $(checkBox).prop('checked', false);
        }
      }
      if($(checkBox).data('status') == 'up-to-date') {
        if($('#merchi-all-products').is(':checked')) {
          $(checkBox).prop('checked', true);
        }
        else {
          $(checkBox).prop('checked', false);
        }
      }
    });
  };

  function fetchProductError(data, offset) {
    alert(
      "There was an error fetching products from Merchi" +
        "Please check the console for more info."
    );
    console.error(data, offset);
  }

  function fetchProducts(offset) {
    MERCHI_SDK.products.get(
      function (data) {
        // console.log('data', data);
        $.merge( allProducts, data );
        return true;
      },
      fetchProductError,
      {
        embed: embed,
        inDomain: merchiObject.merchiStoreName,
        limit: limit,
        offset: offset,
        publicOnly: true,
      }
    );
  }

  $("#merchi-fetch-button").click(function () {
    $("#merchi-fetch-button").html("Fetching...");
    $("#merchi-fetch-button").prop("disabled", true);
    $("#merchi-all-products").prop('checked', false);
    $("#merchi-new-products").prop('checked', false);
    $("#merchi-new-data").prop('checked', false);
    $(".merchi_checkbox").prop('checked', false);
    // Check how many merchi product there are
    MERCHI_SDK.products.get(
      function (data) {
        prepereProducts(data.meta.available);
      },
      function (status, data) {
        console.error(status, data);
        alert("Can not connect to merchi check console.");
      },
      {
        embed: {},
        inDomain: merchiObject.merchiStoreName,
        publicOnly: true,
      }
    );
  });

  // 
  function prepereProducts(productTotal) {
    available = productTotal;
    allProducts = [];
    var offset = 0;
    var num = Math.floor(productTotal/limit) + 1;
    console.log('num', num);
    for (j = 0; j < num; j++) {
      // console.log('offset', offset);
      // var fetch = fetchProducts(offset);
      setTimeout(function() {
        // console.log('offset', offset);
        fetchProducts(offset);
        // console.log('allProducts', allProducts);
        offset += limit;
        available -= limit;
        $("#merchi-progress").val((1 - available / productTotal) * 100);
      }, j * 1000);
    }
    setTimeout(function() {
      console.log('allProducts', allProducts);
      var _products = convertedMerchiProducts(allProducts);
      selectMerchiProducts({ create: _products });
    }, (num+1) * 1000);
  }

  // Show toast
  function toast() {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar");
    // Set text inside snackbar DIV
    $("#snackbar").text(totalAvailable + " Merchi products added.");
    // Add the "show" class to DIV
    x.className = "show";
    // After 3 seconds, remove the show class from DIV
    setTimeout(function () {
      x.className = x.className.replace("show", "");
    }, 3000);
  }
});
