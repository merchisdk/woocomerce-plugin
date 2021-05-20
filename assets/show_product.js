document.addEventListener('DOMContentLoaded', function(event) {
  const productId = merchiShowProductScriptOptions.productId;
  const redirectAfterSuccessUrl = merchiShowProductScriptOptions.redirectAfterSuccessUrl;
  const mountpointClassName = merchiShowProductScriptOptions.mountPointClassName;
  const mountpoint = document.getElementsByClassName(mountpointClassName);
  const script = document.createElement('script');
  script.src = `https://merchi.co//static/product_embed/js/product.embed.js?product=${productId}&hidePreview=true&hideTitle=true&hideInfo=true&hidePrice=true&includeBootstrap=false&singleColumn=true&notIncludeDefaultCss=true&redirectAfterSuccessUrl=${redirectAfterSuccessUrl}`;
  script.dataset.name = "product-embed";
  mountpoint[0].appendChild(script);
});
