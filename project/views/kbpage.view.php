<?php require_once __DIR__ . '/modules/header.php'; ?>
    <section class='content'>
        <div class=container>
            <h2>Service Desk Knowledge Base</h2>
            <div class="faq-section">
                <button class="faq-title"> How to Submit a Support Ticket?</button>
                <div class="faq-content">
                    <p>1. Log in to the E-commerce Admin Panel.</p>
                    <p>2. Navigate to Help Center → Submit a Ticket.</p>
                    <p>3. Fill in details (Order ID, issue type, etc.) and submit.</p>
                </div>
            </div>

            <div class="faq-section">
                <button class="faq-title"> Order Stuck in Processing</button>
                <div class="faq-content">
                    <p>Possible reasons:</p>
                    <p> Payment Not Confirmed. Verify with the payment gateway.</p>
                    <p> Out of Stock. Notify the customer.</p>
                    <p> System Delay – Refresh the order after 30 minutes.</p>
                    </p>
                </div>
            </div>

            <div class="faq-section">
                <button class="faq-title"> Refund Not Processed</button>
                <div class="faq-content">
                    <p>Check if the refund was initiated from the admin panel. If pending, verify with the payment gateway.</p>
                    <p>Customers should expect refunds within 5-7 business days.</p>
                </div>
            </div>

            <div class="faq-section">
                <button class="faq-title"> Website Not Loading</button>
                <div class="faq-content">
                    <p>1. Check if the server is running via System Status.</p>
                    <p>2. Clear cache and try again.</p>
                    <p>3. If the issue persists, check CDN and hosting provider status.</p>
                </div>
            </div>
            <div class='faq-note'>
            Need more support ?If you did not find an answer, please raise a ticket describing the issue

            </div>
        </div>
    </section>
    
<script>
    const faqTitles = document.querySelectorAll(".faq-title");
    faqTitles.forEach(title => {
        title.addEventListener("click", function() {
            const content = this.nextElementSibling;
            content.style.display = content.style.display === "block" ? "none" : "block";
        });
    });
</script>
<?php require_once __DIR__ . '/modules/footer.php'; ?>