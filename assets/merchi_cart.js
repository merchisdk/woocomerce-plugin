document.addEventListener('DOMContentLoaded', function(event) {
  const mountPointClass = merchiCartScriptOptions.mountPointClass;
  const storeId = merchiCartScriptOptions.storeId;
  const mountpoint = document.getElementsByClassName(mountPointClass)[0];
  const script = document.createElement('script')
  script.src =
   `https://merchi.co/static/js/dist/load-component.js?component=RemoteShoppingCart&mountpointClass=${mountPointClass}&onload=merchiComponentLoaded&props={\"storeId\":${storeId}, \"includeModalCss\":true, \"showOpenCartButton\": true, \"cartButtonWrappedInContainer\": true, \"includeBootstrap\": true}`;
  function merchiComponentLoaded() {
    // hidden by css, needs to be shown on load
    mountpoint.style.visibility = 'visible';
  }
  document.body.appendChild(script);
});
