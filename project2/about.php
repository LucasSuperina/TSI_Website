<!--JAY KSHIRSAGAR 105912265-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Lucas Superina 105914669">
    <meta name="description" content="A page about the team who created this website, specifying each of their roles">
    <meta name="keywords" content="Group, Team Members, About, Interests, Terrible Software Inc.">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Terrible Software Inc - About Us</title>
</head>

<?php
    include "about_page_profile.inc";

    include "header.inc";
?>

<body class="about">
    <div class="container">
        <div class="glass-container">
            <?php createHeader("About"); ?>
            <main class="main">
                <section>
                    <h1>About Us</h1>
                    <h2 id="group_header">Group Information</h2>
                </section>
                <section id="skills_and_info">
                    <article>
                        <h3>Group member skills.</h3>
                        <ul>
                            <li>Maggie: "can make great ☕ no 🧢"</li>
                            <li>Soup: Makes terrible indie games, and gnocchi</li>
                            <li>Pujan: Cooking, as well as athleticism</li>
                            <li>Jay: Jack of all trades, master of at least 3</li>
                        </ul>
                    </article>
                    <article>
                        <h3>General Information</h3>
                        <ul>
                            <li>Group Name: Terrible Software Incorporated Ltd.</li>
                            <li>Class Time and Day: 2:30PM, Thursday</li>
                            <li>Tutor Name: Nicholas Enrique Ketterer Ortiz</li>
                            <li>Class ID: 1-14</li>
                        </ul>
                    </article>
                    <article>
                        <h3>Student IDs</h3>
                        <ul>
                            <li>Maggie: 103488683</li>
                            <li>Soup: 105914669</li>
                            <li>Jay: 105912265</li>
                            <li>Pujan: 105920242</li>
                        </ul>
                    </article>
                </section>
                <figure id="group_photo">
                    <img src="./Images/studio_ghibli.jpg" alt='Pixel art of the group standing infront of a whiteboard. The whiteboard reads "TSI, Best Company"'>
                    <figcaption>Group Photo of TSI Members</figcaption>
                </figure>
                <section class="main-soup">
                    <h1 id="contributions_heading">Contributions</h1>
                    <dl class="contributions">

                    <?php 
                        about_profile(
                            "Soup", "./Images/Soup_Icon.webp", "Soup's Icon: A small bowl of chicken soup.", 
                            ["About page (what you're reading!) HTML", "About page CSS", "Jira and Github creation", "Github Management"]
                        );

                        about_profile(
                            "Maggie", "./Images/Maggie_Icon.webp", "Maggie's Icon: A cartoon of a capybara receeding into bush.", 
                            ["Apply page HTML", "Apply page CSS", "Page Template HTML and CSS", "File structure management"]
                        );

                        about_profile(
                            "Pujan", "./Images/Pujan_Icon.webp", "Jay's Icon: A cartoon of a goose standing over a well.", 
                            ["Job Descriptions page HTML", "Job Descriptions page CSS", "Jira Management"]
                        );

                        about_profile(
                            "Jay", "./Images/Jay_Icon.webp", "Jay's Icon: A photo of him wearing paper mache glasses, which have eyes drawn on.", 
                            ["Home page HTML", "Home page CSS", "HTML file management"]
                        );
                    ?>
                        
                    </dl>
                </section>
                    <table>
                        <thead>
                            <tr>
                                <th colspan="5" id="table_heading">Group Member Interests!</th>
                            </tr>
                            <tr>
                                <td> </td>
                                <th>Maggie</th>
                                <th>Soup</th>
                                <th>Pujan</th>
                                <th>Jay</th>
                            </tr>
                        </thead> 
                        <tbody>
                            <tr>
                                <th>Music</th>
                                <td>Classical, Rock, Punk, Jazz, R&B</td>
                                <td>I'm not even sure where to start</td>
                                <td>90% R&B (what is the other 10%? We will never know...)</td>
                                <td>Pop, Hip-hop</td>
                            </tr>
                            <tr>
                                <th>Games</th>
                                <td>Rust, Sudoku, Solitaire, Strategic games</td>
                                <td>Narrative based indie RPGs or deranged FPS'</td>
                                <td>Minecraft, Adventure + Action w/ good stories</td>
                                <td>Souls, Elden Ring, PvP, Adventure</td>
                            </tr>
                            <tr>
                                <th>Peak valorant rank but expressed as a zoomer meme.</th>
                                <td>"So we're in cooper"</td>
                                <td>"I'm diamond one"</td>
                                <td colspan="2">(does not play valorant)</td>
                            </tr>
                            <tr>
                                <th>Movies</th>
                                <td>Sci-fi, has watched the Harry Potter & Fantastic Beats movies 5 times, "don't like dramas[sic]"</td>
                                <td>Better Call Saul, Severance, Heat, I could take up the whole table</td>
                                <td>Action, Adventure, Studio Ghibli, "anything that's not corny romance[sic]"</td>
                                <td>Cars 1,2,3, Top Gear S1-22 and The Grand Tour</td>
                            </tr>
                            <tr>
                                <th>Miscellaneous</th>
                                <td>Has not read a book science high school</td>
                                <td>Stole a dollars worth of nuts and bolts from bunnings when he was 8</td>
                                <td>Loves Ducks, Geese and Penguins</td>
                                <td>Afraid of manual labour</td>
                            </tr>
                        </tbody>
                    </table>
            </main>
        </div>
    </div>
</body>

<?php include "footer.inc"?>
