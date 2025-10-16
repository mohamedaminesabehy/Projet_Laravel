document.addEventListener('DOMContentLoaded', function () {
    const aiSummaryButton = document.getElementById('aiSummaryButton');
    const aiSummaryContentDiv = document.getElementById('aiSummaryContent');
    const aiEncouragementContentDiv = document.getElementById('aiEncouragementContent');
    const aiSummaryModal = new bootstrap.Modal(document.getElementById('aiSummaryModal'));

    if (aiSummaryButton) {
        aiSummaryButton.addEventListener('click', function () {
            const bookId = this.dataset.bookId;
            if (!bookId) {
                aiSummaryContentDiv.innerHTML = '<div class="ai-error"><p>Erreur: ID du livre non trouvé.</p></div>';
                aiEncouragementContentDiv.innerHTML = '';
                return;
            }

            // Loading skeletons for a polished UX (identical for both sections)
            const skeleton = `
                <div class="ai-skeleton">
                    <div class="ske-title"></div>
                    <div class="ske-line"></div>
                    <div class="ske-line"></div>
                    <div class="ske-tags"></div>
                </div>`;
            aiSummaryContentDiv.innerHTML = skeleton;
            aiEncouragementContentDiv.innerHTML = skeleton;

            // Show the modal
            aiSummaryModal.show();

            fetch(`/api/ai-summary/${bookId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    // Build Summary Card
                    let summaryHtml = `
                        <div class="ai-card ai-summary">
                            <div class="ai-card__header">
                                <span class="ai-icon"><i class="fa-solid fa-book-open"></i></span>
                                <h5>Résumé du livre</h5>
                            </div>
                            <div class="ai-card__body">`;
                    const s = data.summary;
                    if (typeof s === 'string') {
                        summaryHtml += `<p>${s}</p>`;
                    } else if (Array.isArray(s)) {
                        summaryHtml += `<ul class="ai-list">${s.map(it => `<li>${it}</li>`).join('')}</ul>`;
                    } else if (s && typeof s === 'object') {
                        if (s.title) summaryHtml += `<p><strong>Titre:</strong> ${s.title}</p>`;
                        if (s.author) summaryHtml += `<p><strong>Auteur:</strong> ${s.author}</p>`;
                        if (s.plot) summaryHtml += `<p><strong>Intrigue:</strong> ${s.plot}</p>`;
                        if (s.themes && s.themes.length > 0) {
                            summaryHtml += `<div class="ai-tags"><span class="ai-label">Thèmes:</span>${s.themes.map(t => `<span class=\"ai-tag\">${t}</span>`).join('')}</div>`;
                        }
                        if (s.unique_aspects && s.unique_aspects.length > 0) {
                            summaryHtml += `<div class="ai-tags"><span class="ai-label">Aspects uniques:</span>${s.unique_aspects.map(t => `<span class=\"ai-tag ai-tag--accent\">${t}</span>`).join('')}</div>`;
                        }
                        if (s.content) summaryHtml += `<p>${s.content}</p>`;
                    } else {
                        summaryHtml += '<p>Aucun résumé disponible.</p>';
                    }
                    summaryHtml += `</div></div>`;
                    aiSummaryContentDiv.innerHTML = summaryHtml;
                    // trigger enter animation
                    requestAnimationFrame(() => {
                        document.querySelectorAll('#aiSummaryContent .ai-card').forEach(el => el.classList.add('ai-show'));
                    });

                    // Build Encouragement Card (identical style & display to Summary)
                    let encouragementHtml = `
                        <div class="ai-card ai-encouragement">
                            <div class="ai-card__header">
                                <span class="ai-icon"><i class="fa-solid fa-bolt"></i></span>
                                <h5>Encouragement à l\'achat</h5>
                            </div>
                            <div class="ai-card__body">`;
                    const e = data.encouragement;
                    if (typeof e === 'string') {
                        encouragementHtml += `<p>${e}</p>`;
                    } else if (Array.isArray(e)) {
                        encouragementHtml += `<ul class="ai-list">${e.map(it => `<li>${it}</li>`).join('')}</ul>`;
                    } else if (e && typeof e === 'object') {
                        if (e.message) encouragementHtml += `<p>${e.message}</p>`;
                        if (Array.isArray(e.bullets) && e.bullets.length) {
                            encouragementHtml += `<ul class="ai-list">${e.bullets.map(b => `<li>${b}</li>`).join('')}</ul>`;
                        }
                        // Optional tags alignment if present (keywords, reasons, selling_points)
                        const tags = e.tags || e.keywords || e.reasons || e.selling_points;
                        if (Array.isArray(tags) && tags.length) {
                            encouragementHtml += `<div class="ai-tags">${tags.map(t => `<span class=\"ai-tag\">${t}</span>`).join('')}</div>`;
                        }
                        const cta = e.call_to_action || e.cta;
                        if (cta) encouragementHtml += `<p class="ai-cta"><i class="fa-solid fa-hand-pointer"></i> ${cta}</p>`;
                    } else {
                        encouragementHtml += '<p>Aucun encouragement disponible.</p>';
                    }
                    encouragementHtml += `</div></div>`;
                    aiEncouragementContentDiv.innerHTML = encouragementHtml;
                    // trigger enter animation
                    requestAnimationFrame(() => {
                        document.querySelectorAll('#aiEncouragementContent .ai-card').forEach(el => el.classList.add('ai-show'));
                    });
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération du résumé AI:', error);
                    aiSummaryContentDiv.innerHTML = '<div class="ai-error"><p>Erreur lors du chargement du résumé. Veuillez réessayer plus tard.</p></div>';
                    aiEncouragementContentDiv.innerHTML = '';
                });
        });
    }
});