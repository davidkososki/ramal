var itemsPerPage = 5;
      var currentPage = 1;
      var totalPages = Math.ceil(data.length / itemsPerPage);

      function displayData(items, container) {
        var dataContainer = document.getElementById(container);
        dataContainer.innerHTML = "";

        var inicio = (currentPage - 1) * itemsPerPage;
        var fim = inicio + itemsPerPage;

        for (var i = inicio; i < fim && i < data.length; i++) {
            var div = document.createElement('div');
            div.className = 'card text-dark mb-3';

            var header = document.createElement('h5');
            header.className = 'card-header';
            header.textContent = data[i].nome_pessoa + ' ';

            var small = document.createElement('small');
            small.textContent = data[i].sigla_gerencia+"/"+data[i].sigla_diretoria;
            header.appendChild(small);

            var body = document.createElement('div');
            body.className = 'card-body';
            body.textContent = data[i].telefone_pessoa;

            div.appendChild(header);
            div.appendChild(body);

            dataContainer.appendChild(div);
        }
      }

      function setupPagination(pages, container) {
        var pagination = document.getElementById(container);
        pagination.innerHTML = "";

        for (var i = 1; i <= pages; i++) {
          var pageItem = document.createElement('li');
          var pageLink = document.createElement('a');
          pageLink.href = "#";
          pageLink.textContent = i;

          if (i === currentPage) {
            pageLink.classList.add('active');
          }

          pageLink.addEventListener('click', function () {
            currentPage = parseInt(this.textContent);
            displayData(data.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage), 'data');
            setupPagination(totalPages, 'pagination');
          });

          pageItem.appendChild(pageLink);
          pagination.appendChild(pageItem);
        }
      }

      displayData(data.slice(0, itemsPerPage), 'data');
      setupPagination(totalPages, 'pagination');      


