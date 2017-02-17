<script type="text/javascript">
  //定义基础ip
  var base_url = "http://192.168.99.";
  var ports = ['80','443','21','8080','23','18083'];
  for(var i=0; i<=255; i++)
  {
    var url = base_url + i;
    for(var j=0; j<ports.length; j++)
    {
      url += ":" + ports[j];
      var ifr = document.createElement("iframe");
      ifr.src = url;
      document.body.appendChild(ifr);
      ifr.onload = function(){
        document.body.appendChild(ifr);
        console.log(url);
      }
    }
  }
</script>
