<form method="POST" action="<?= htmlspecialchars($action) ?>" class="grid-form" id="patientForm">
    <?php if (!empty($patient['id'])): ?>
        <input type="hidden" name="id" value="<?= (int)$patient['id'] ?>">
    <?php endif; ?>

    <label>Nombre completo*
        <input type="text" name="full_name" required value="<?= htmlspecialchars($patient['full_name'] ?? '') ?>">
    </label>
    <label>Tipo de documento*
        <select name="document_type" required>
            <?php $doc = $patient['document_type'] ?? ''; ?>
            <option value="">Seleccione</option>
            <option value="CC" <?= $doc === 'CC' ? 'selected' : '' ?>>CC</option>
            <option value="TI" <?= $doc === 'TI' ? 'selected' : '' ?>>TI</option>
            <option value="CE" <?= $doc === 'CE' ? 'selected' : '' ?>>CE</option>
            <option value="PAS" <?= $doc === 'PAS' ? 'selected' : '' ?>>PAS</option>
        </select>
    </label>
    <label>Dirección*
        <input type="text" name="address" required value="<?= htmlspecialchars($patient['address'] ?? '') ?>">
    </label>
    <label>Teléfono
        <input type="text" name="phone" value="<?= htmlspecialchars($patient['phone'] ?? '') ?>">
    </label>
    <label>Celular*
        <input type="text" name="mobile" required value="<?= htmlspecialchars($patient['mobile'] ?? '') ?>">
    </label>
    <label>Fecha de nacimiento*
        <input type="date" name="birth_date" id="birthDate" required value="<?= htmlspecialchars($patient['birth_date'] ?? '') ?>">
    </label>
    <label>Edad*
        <input type="number" name="age" id="age" required min="0" value="<?= htmlspecialchars((string)($patient['age'] ?? '')) ?>">
    </label>
    <label>EPS*
        <input type="text" name="eps" required value="<?= htmlspecialchars($patient['eps'] ?? '') ?>">
    </label>
    <label>Contacto adicional
        <input type="text" name="additional_contact" value="<?= htmlspecialchars($patient['additional_contact'] ?? '') ?>">
    </label>
    <label>Parentesco
        <input type="text" name="kinship" value="<?= htmlspecialchars($patient['kinship'] ?? '') ?>">
    </label>
    <label>Tipo de examen*
        <input type="text" name="exam_type" required value="<?= htmlspecialchars($patient['exam_type'] ?? '') ?>">
    </label>
    <label>Empresa solicitante*
        <input type="text" name="company" required value="<?= htmlspecialchars($patient['company'] ?? '') ?>">
    </label>
    <label>Fecha de examen*
        <input type="date" name="exam_date" required value="<?= htmlspecialchars($patient['exam_date'] ?? '') ?>">
    </label>

    <button type="submit" class="full">Guardar</button>
</form>
