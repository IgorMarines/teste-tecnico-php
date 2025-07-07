const carrinhoDiv = document.getElementById('carrinho');
const freteDiv = document.getElementById('frete');
const erroDiv = document.getElementById('erros');

let estoque = {};

// WebSocket para estoque
const socket = new WebSocket('ws://localhost:8080');
socket.onmessage = (e) => {
  const data = JSON.parse(e.data);
  estoque[data.id] = data.disponivel;
  atualizarEstoque();
};

// Busca dados do carrinho
async function carregarCarrinho() {
  try {
    const res = await fetch('/carrinho.php');
    const produtos = await res.json();

    carrinhoDiv.innerHTML = '';
    produtos.forEach(p => {
      const div = document.createElement('div');
      div.className = 'card';
      div.innerHTML = `
        <p><strong>${p.nome}</strong></p>
        <p>R$ ${p.preco.toFixed(2)} x ${p.quantidade}</p>
        <p id="estoque-${p.id}">Verificando estoque...</p>
      `;
      carrinhoDiv.appendChild(div);
    });
  } catch (err) {
    erroDiv.textContent = 'Erro ao carregar o carrinho.';
  }
}

// Busca dados do frete
async function carregarFrete() {
  try {
    const res = await fetch('./frete.php');
    const dados = await res.json();

    freteDiv.innerHTML = `
      <p>Frete padrão: R$ ${dados.padrao}</p>
      <p>Frete expresso: R$ ${dados.expresso}</p>
    `;
  } catch (err) {
    freteDiv.innerHTML = '<p class="erro">Erro ao consultar o frete.</p>';
  }
}

// Atualiza a disponibilidade no DOM
function atualizarEstoque() {
  for (const id in estoque) {
    const el = document.getElementById(`estoque-${id}`);
    if (!el) continue;

    el.textContent = estoque[id] ? '✔ Em estoque' : '❌ Fora de estoque';
    if (!estoque[id]) el.classList.add('estoque-baixo');
  }
}

carregarCarrinho();
carregarFrete();
