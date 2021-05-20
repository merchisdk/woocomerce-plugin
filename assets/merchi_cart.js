document.addEventListener('DOMContentLoaded', function(event) {
  const mountPointClass = merchiCartScriptOptions.mountPointClass;
  const storeId = merchiCartScriptOptions.storeId;
  const mountpoint = document.getElementsByClassName(mountPointClass)[0];
  const merchiScriptMountPoint = document.createElement('div');
  merchiScriptMountPoint.className = 'merchi-mountpoint';
  const script = document.createElement('script');
  script.src =
   `https://merchi.co/static/js/dist/load-component.js?component=RemoteShoppingCart&mountpointClass=merchi-mountpoint&onload=merchiComponentLoaded&props={\"storeId\":${storeId}, \"includeModalCss\":true, \"showOpenCartButton\": false, \"cartButtonWrappedInContainer\": false, \"includeBootstrap\": false}`;
   const jqScript = document.createElement('script');
   jqScript.text = `jQuery(document).ready(function () { jQuery('.${mountPointClass}').click(function () { window.openMerchiCart(); }); })`;
   function merchiComponentLoaded() {
    // hidden by css, needs to be shown on load

    mountpoint.style.visibility = 'visible';
  }
  
  window.merchiComponentLoaded = merchiComponentLoaded;
  
  document.body.appendChild(merchiScriptMountPoint);
  document.body.appendChild(script);
  document.body.appendChild(jqScript);
 });
