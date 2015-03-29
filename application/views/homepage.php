<div class="row">
    <table class="table">
        <tr>
            <th>Order Name</th>
            <th>Customer</th>
            <th>View</th>
        </tr>
        {orders}
        <tr>
            <td>{order}</td>
            <td>{customer}</td>
            <td><a href="{url}" class="btn btn-primary">View</td>
        </tr>
        {/orders}
    </table>
</div>