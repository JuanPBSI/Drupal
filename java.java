            String query = "SELECT * FROM employee WHERE userid = " + userId + " and password = '" + password + "'";

			try
            {
                Statement answer_statement = WebSession.getConnection(s)
                        .createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE, ResultSet.CONCUR_READ_ONLY);
                ResultSet answer_results = answer_statement.executeQuery(query);
                if (answer_results.first())
                {
                    setSessionAttribute(s, getLessonName() + ".isAuthenticated", Boolean.TRUE);
                    setSessionAttribute(s, getLessonName() + "." + GoatHillsFinancial.USER_ID, Integer.toString(userId));
                    authenticated = true;
                }

            } catch (SQLException sqle)