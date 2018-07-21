       <select name="category" class="search__form--selectBoxes-item" id="activeCategory">
            <option value='empty'>Category</option>
            <?php while($row = $categories->fetch_assoc()) : ?>
            <option value="<?php echo $row['category']; ?>" <?php echo $selected; ?>>
                <?php echo $row['category']; ?>
            </option>
            <?php endwhile; ?>
        </select>
        <select name="jobtype" class="search__form--selectBoxes-item" id="">
            <option value='empty'>Job Type</option>
            <?php while($row = $jobtypes->fetch_assoc()) : ?>
            <option value="<?php echo $row['jobType']; ?>" <?php echo $selected; ?>>
                <?php echo $row['jobType']; ?>
            </option>
            <?php endwhile; ?>
        </select>
        <select name="location" class="search__form--selectBoxes-item" id="">
            <option value='empty'>Location</option>
            <?php while($row = $locations->fetch_assoc()) : ?>
            <option value="<?php echo $row['location']; ?>" <?php echo $selected; ?>>
                <?php echo $row['location']; ?>
            </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="submit" class="search__form--selectBoxes-item">Submit</button>