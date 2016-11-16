            String query = "SELECT * FROM employee WHERE userid = ? and password = ?";

			try
            {
                Connection connection = WebSession.getConnections(s);
				PreparedStatement statement = connection.prepareStatement(query, ResultSet.TYPE_SCROLL_INSENSITIVE, ResultSet.CONCUR_READ_ONLY);
				statement.setString(1, userId);
				statement.setString(2, password);
				ResultSet answer_results = statement.executeQuery();
                if (answer_results.first())
                {
                    setSessionAttribute(s, getLessonName() + ".isAuthenticated", Boolean.TRUE);
                    setSessionAttribute(s, getLessonName() + "." + GoatHillsFinancial.USER_ID, Integer.toString(userId));
                    authenticated = true;
                }

            } catch (SQLException sqle)