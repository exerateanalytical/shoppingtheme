/* Alluvia — commerce enhancements: branded +/- quantity steppers that stay in
   sync with WooCommerce's native cart/add-to-cart (dispatches a real change event). */
(function () {
	'use strict';

	function enhance(q) {
		if (q.dataset.alluviaQty) { return; }
		var input = q.querySelector('input.qty');
		if (!input) { return; }
		q.dataset.alluviaQty = '1';

		var step = parseFloat(input.getAttribute('step')) || 1;

		function bump(dir) {
			var min = parseFloat(input.getAttribute('min'));
			var maxAttr = input.getAttribute('max');
			var max = parseFloat(maxAttr);
			var cur = parseFloat(input.value);
			if (isNaN(cur)) { cur = isNaN(min) ? 0 : min; }
			var next = cur + dir * step;
			if (!isNaN(min) && next < min) { next = min; }
			if (maxAttr && !isNaN(max) && next > max) { next = max; }
			if (next < 0) { next = 0; }
			input.value = next;
			input.dispatchEvent(new Event('change', { bubbles: true }));
			input.dispatchEvent(new Event('input', { bubbles: true }));
		}

		var minus = document.createElement('button');
		minus.type = 'button';
		minus.className = 'alluvia-qty-btn alluvia-qty-minus';
		minus.setAttribute('aria-label', 'Decrease quantity');
		minus.textContent = '−';
		minus.addEventListener('click', function () { bump(-1); });

		var plus = document.createElement('button');
		plus.type = 'button';
		plus.className = 'alluvia-qty-btn alluvia-qty-plus';
		plus.setAttribute('aria-label', 'Increase quantity');
		plus.textContent = '+';
		plus.addEventListener('click', function () { bump(1); });

		q.insertBefore(minus, input);
		q.appendChild(plus);
	}

	function init() {
		var nodes = document.querySelectorAll('.woocommerce .quantity, .woocommerce-page .quantity');
		Array.prototype.forEach.call(nodes, enhance);
	}

	if (document.readyState !== 'loading') { init(); }
	else { document.addEventListener('DOMContentLoaded', init); }

	// Re-run after WooCommerce replaces cart fragments / cart totals.
	document.body.addEventListener('updated_cart_totals', init);
	document.body.addEventListener('updated_wc_div', init);
	document.body.addEventListener('wc_fragments_refreshed', init);
})();
