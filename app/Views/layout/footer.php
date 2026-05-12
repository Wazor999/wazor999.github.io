<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


<script>

document.getElementById('telephone').addEventListener('keyup', function(){

let tel = this.value;

if(tel.length >= 7){

fetch('/clients/search/' + tel)

.then(response => response.json())

.then(data => {

if(data.status === 'found'){

document.getElementById('nom_client').value = data.nom;

}else{

document.getElementById('nom_client').value = '';

}

});

}

});

</script>

</div>
</body>
</html>