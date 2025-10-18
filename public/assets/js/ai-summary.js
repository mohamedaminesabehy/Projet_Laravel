document.addEventListener('DOMContentLoaded', function () {
    const aiSummaryButton = document.getElementById('aiSummaryButton');
    const aiSummaryModal = new bootstrap.Modal(document.getElementById('aiSummaryModal'));
    const aiSummaryContent = document.getElementById('aiSummaryContent');

    if (aiSummaryButton) {
        aiSummaryButton.addEventListener('click', async function () {
            aiSummaryContent.innerHTML = 'Génération du résumé et des encouragements par l\'IA...';
            aiSummaryModal.show();

            try {
                const bookId = this.dataset.bookId; // Assuming you add data-book-id to the button
                const response = await fetch(`/api/ai-summary/${bookId}`); // Adjust API endpoint as needed
                const data = await response.json();

                if (response.ok) {
                    aiSummaryContent.innerHTML = `<strong>Résumé:</strong> ${data.summary}<br><br><strong>Encouragements:</strong> ${data.encouragement}`; 
                } else {
                    aiSummaryContent.innerHTML = `Erreur: ${data.message || 'Impossible de générer le résumé.'}`; 
                }
            } catch (error) {
                console.error('Erreur lors de l\'appel à l\'API Gemini:', error);
                aiSummaryContent.innerHTML = 'Une erreur est survenue lors de la communication avec l\'IA.';
            }
        });
    }
});