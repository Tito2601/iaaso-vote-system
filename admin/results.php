<style>
.card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.1);
    border: 1px solid #e3eaf7;
    padding: 25px;
    margin: 70px auto 20px auto;
    max-width: 500px;
    width: 85%;
}

.admin-info {
    text-align: center;
    margin-bottom: 20px;
    padding: 15px;
    background: #f4f8fc;
    border-radius: 6px;
    border: 1px solid #e3eaf7;
}

.admin-name {
    font-size: 1.2em;
    font-weight: bold;
    color: #1a237e;
    margin: 0 0 6px 0;
}

.admin-role {
    color: #1565c0;
    margin: 0;
    font-size: 0.95em;
}

.results-container {
    background: #fff;
    border: 1px solid #e3eaf7;
    border-radius: 6px;
    padding: 15px;
    margin-bottom: 15px;
}

.total-votes {
    text-align: center;
    font-size: 1em;
    color: #1a237e;
    padding: 12px;
    background: #f4f8fc;
    border-radius: 4px;
    margin-bottom: 15px;
    border: 1px solid #e3eaf7;
}

.position-section {
    margin-bottom: 25px;
}

.position-section:last-child {
    margin-bottom: 0;
}

.position-section h3 {
    color: #1565c0;
    margin-bottom: 12px;
    padding-bottom: 6px;
    border-bottom: 2px solid #e3eaf7;
    font-size: 1.1em;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
    background: #fff;
    font-size: 0.9em;
}

thead {
    background: #1565c0;
    color: #fff;
}

th {
    padding: 8px 10px;
    text-align: left;
    font-weight: 600;
}

td {
    padding: 8px 10px;
    border-bottom: 1px solid #e3eaf7;
    color: #1a237e;
}

tr:last-child td {
    border-bottom: none;
}

tr:hover {
    background: #f4f8fc;
}

.bottom-links {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #e3eaf7;
}

.back-button {
    display: inline-block;
    background: #1565c0;
    color: #fff;
    padding: 8px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.2s;
    font-size: 0.95em;
}

.back-button:hover {
    background: #0d47a1;
    text-decoration: none;
    transform: translateY(-1px);
}

.logout-button {
    display: inline-block;
    background: #c0392b;
    color: #fff;
    padding: 8px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.2s;
    font-size: 0.95em;
}

.logout-button:hover {
    background: #a93226;
    text-decoration: none;
    transform: translateY(-1px);
}

@media screen and (max-width: 600px) {
    .card {
        padding: 15px;
        margin: 70px auto 15px auto;
        width: 90%;
    }

    th, td {
        padding: 6px 8px;
        font-size: 0.85em;
    }
}
</style> 