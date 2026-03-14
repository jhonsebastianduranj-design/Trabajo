<section class="card">
    <div class="section-title">
        <h2>Listado de pacientes</h2>
        <a href="/patients/create" class="button-link">+ Registrar paciente</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Celular</th>
                    <th>Examen</th>
                    <th>Empresa</th>
                    <th>Fecha examen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($patients)): ?>
                    <tr><td colspan="7">No hay pacientes registrados.</td></tr>
                <?php else: ?>
                    <?php foreach ($patients as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['full_name']) ?></td>
                            <td><?= htmlspecialchars($p['document_type']) ?></td>
                            <td><?= htmlspecialchars($p['mobile']) ?></td>
                            <td><?= htmlspecialchars($p['exam_type']) ?></td>
                            <td><?= htmlspecialchars($p['company']) ?></td>
                            <td><?= htmlspecialchars($p['exam_date']) ?></td>
                            <td>
                                <a href="/patients/edit?id=<?= (int)$p['id'] ?>">Editar</a> |
                                <a href="/patients/delete?id=<?= (int)$p['id'] ?>" onclick="return confirm('¿Eliminar paciente?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
